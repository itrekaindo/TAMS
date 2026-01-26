<?php

namespace App\Console\Commands;

use App\Mail\PeminjamanTerlambatMail;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CekPeminjamanTerlambat extends Command
{
    protected $signature = 'peminjaman:cek-terlambat';
    protected $description = 'Cek peminjaman yang terlambat dan kirim email notifikasi pada hari tertentu';

    public function handle()
    {
        // Cari semua peminjaman yang terlambat
        $peminjamanTerlambat = Peminjaman::where('tanggal_kembali_rencana', '<', Carbon::today())
            ->where('status', 'dipinjam')
            ->with(['details.alat', 'peminjam'])
            ->get();

        $this->info('Ditemukan ' . $peminjamanTerlambat->count() . ' peminjaman yang terlambat.');

        $emailTerkirim = 0;

        foreach ($peminjamanTerlambat as $peminjaman) {
            $hariTerlambat = Carbon::parse($peminjaman->tanggal_kembali_rencana)->diffInDays(Carbon::today());

            // Kirim email hanya pada hari tertentu:
            // Hari ke-1, 3, 7, 14, 21, 28, dst (setiap 7 hari setelah hari ke-7)
            $shouldSendEmail = false;

            if ($hariTerlambat == 1 || $hariTerlambat == 3 || $hariTerlambat == 7) {
                $shouldSendEmail = true;
            } elseif ($hariTerlambat > 7 && ($hariTerlambat - 7) % 7 == 0) {
                // Setiap 7 hari setelah hari ke-7 (hari 14, 21, 28, dst)
                $shouldSendEmail = true;
            }

            if ($shouldSendEmail) {
                try {
                    Mail::to($peminjaman->email)->send(new PeminjamanTerlambatMail($peminjaman));

                    $emailTerkirim++;
                    $this->info('✓ Email keterlambatan dikirim ke: ' . $peminjaman->email . ' (' . $peminjaman->nama_peminjam . ') - Terlambat ' . $hariTerlambat . ' hari');
                } catch (\Exception $e) {
                    $this->error('✗ Gagal mengirim email ke: ' . $peminjaman->email . ' - Error: ' . $e->getMessage());
                }
            } else {
                $this->line('○ Skip email untuk: ' . $peminjaman->nama_peminjam . ' - Terlambat ' . $hariTerlambat . ' hari (bukan hari pengiriman)');
            }
        }

        $this->info('Selesai. Total email berhasil dikirim: ' . $emailTerkirim);

        return Command::SUCCESS;
    }
}
