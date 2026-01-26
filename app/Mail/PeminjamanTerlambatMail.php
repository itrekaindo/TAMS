<?php

namespace App\Mail;

use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class PeminjamanTerlambatMail extends Mailable
{
    use Queueable, SerializesModels;

    public $peminjaman;
    public $hariTerlambat;

    /**
     * Create a new message instance.
     */
    public function __construct(Peminjaman $peminjaman)
    {
        $this->peminjaman = $peminjaman;

        // Hitung jumlah hari keterlambatan
        $tanggalKembaliRencana = Carbon::parse($peminjaman->tanggal_kembali_rencana);
        $today = Carbon::today();
        $this->hariTerlambat = $tanggalKembaliRencana->diffInDays($today, false);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Peringatan Keterlambatan Pengembalian - ' . $this->peminjaman->kode_peminjaman,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.peminjaman-terlambat',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
