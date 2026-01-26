<?php

namespace App\Console\Commands;

use App\Mail\ReminderPengembalianMail;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ReminderPengembalian extends Command
{
    protected $signature = 'peminjaman:reminder-pengembalian';
    protected $description = 'Kirim reminder H-1 sebelum tanggal pengembalian';

    public function handle()
    {
        $besok = Carbon::tomorrow()->toDateString();

        // Cari peminjaman yang tanggal kembali rencana adalah besok dan status masih dipinjam
        $peminjamanBesok = Peminjaman::where('tanggal_kembali_rencana', $besok)
            ->where('status', 'dipinjam')
            ->with(['details.alat', 'peminjam'])
            ->get();

        $this->info('Ditemukan ' . $peminjamanBesok->count() . ' peminjaman yang jatuh tempo besok.');

        foreach ($peminjamanBesok as $peminjaman) {
            try {
                Mail::to($peminjaman->email)->send(new ReminderPengembalianMail($peminjaman));

                $this->info('✓ Reminder dikirim ke: ' . $peminjaman->email . ' (' . $peminjaman->nama_peminjam . ')');
            } catch (\Exception $e) {
                $this->error('✗ Gagal mengirim reminder ke: ' . $peminjaman->email . ' - Error: ' . $e->getMessage());
            }
        }

        $this->info('Selesai. Total reminder berhasil dikirim: ' . $peminjamanBesok->count());

        return Command::SUCCESS;
    }
}
