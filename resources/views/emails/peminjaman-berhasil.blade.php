<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Peminjaman Alat</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .info-box h3 {
            margin-top: 0;
            color: #667eea;
            font-size: 16px;
        }
        .info-item {
            margin: 10px 0;
        }
        .info-item strong {
            color: #555;
            display: inline-block;
            width: 180px;
        }
        .kode-peminjaman {
            background-color: #667eea;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .alert-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .alert-box p {
            margin: 5px 0;
            color: #856404;
        }
        .tanggal-kembali {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
        }
        .tanggal-kembali h3 {
            margin: 0 0 10px 0;
            color: #155724;
        }
        .tanggal-kembali .tanggal {
            font-size: 20px;
            font-weight: bold;
            color: #28a745;
        }
        .alat-list {
            margin: 20px 0;
        }
        .alat-item {
            background-color: #f8f9fa;
            padding: 12px;
            margin: 8px 0;
            border-radius: 5px;
            border-left: 3px solid #667eea;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Peminjaman Alat Berhasil</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Konfirmasi Peminjaman Anda</p>
        </div>

        <div class="content">
            <p>Yth. <strong>{{ $peminjaman->nama_lengkap }}</strong>,</p>

            <p>Peminjaman alat Anda telah berhasil dicatat dalam sistem kami. Berikut adalah detail peminjaman Anda:</p>

            <div class="info-box">
                <h3>📋 Informasi Peminjam</h3>
                <div class="info-item">
                    <strong>Nama</strong>: {{ $peminjaman->nama_lengkap }}
                </div>
                <div class="info-item">
                    <strong>NIP</strong>: {{ $peminjaman->nip }}
                </div>
                <div class="info-item">
                    <strong>Departemen</strong>: {{ $peminjaman->departemen }}
                </div>
                <div class="info-item">
                    <strong>Email</strong>: {{ $peminjaman->email }}
                </div>
                <div class="info-item">
                    <strong>Telepon</strong>: {{ $peminjaman->telepon }}
                </div>
            </div>

            <h3 style="color: #667eea; margin-top: 30px;">🔑 Kode Peminjaman Anda:</h3>
            <div class="kode-peminjaman">
                {{ $peminjaman->kode_peminjaman }}
            </div>
            <p style="text-align: center; color: #666; font-size: 14px;">
                <em>Simpan kode ini untuk pengembalian alat</em>
            </p>

            <div class="info-box">
                <h3>📦 Alat yang Dipinjam</h3>
                <div class="alat-list">
                    @foreach($peminjaman->details as $detail)
                    <div class="alat-item">
                        <strong>{{ $detail->nama_alat }}</strong> ({{ $detail->kode_alat }})<br>
                        Jumlah: {{ $detail->jumlah }} unit | Kondisi: {{ ucfirst($detail->kondisi_alat) }}
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="info-box">
                <h3>📅 Informasi Tanggal</h3>
                <div class="info-item">
                    <strong>Tanggal Peminjaman</strong>: {{ $peminjaman->tanggal_pinjam->isoFormat('dddd, D MMMM Y') }}
                </div>
                <div class="info-item">
                    <strong>Keperluan</strong>: {{ $peminjaman->keperluan }}
                </div>
            </div>

            <div class="tanggal-kembali">
                <h3>⏰ Tanggal Rencana Pengembalian</h3>
                <div class="tanggal">
                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali_rencana)->isoFormat('dddd, D MMMM Y') }}
                </div>
            </div>

            <div class="alert-box">
                <p><strong>⚠️ Penting!</strong></p>
                <p>Harap mengembalikan alat yang dipinjam <strong>sebelum atau pada tanggal {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali_rencana)->isoFormat('D MMMM Y') }}</strong>.</p>
                <p>Keterlambatan pengembalian dapat mempengaruhi peminjaman Anda selanjutnya.</p>
            </div>

            <h3 style="color: #667eea; margin-top: 30px;">📝 Cara Pengembalian:</h3>
            <ol style="line-height: 2;">
                <li>Kunjungi halaman pengembalian alat</li>
                <li>Masukkan <strong>Kode Peminjaman</strong> Anda</li>
                <li>Upload foto alat yang akan dikembalikan</li>
                <li>Isi kondisi alat dan keterangan jika ada</li>
                <li>Submit pengembalian</li>
            </ol>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('pengembalian.cari') }}" class="button">
                    Kembalikan Alat Sekarang
                </a>
            </div>

            <p style="margin-top: 30px; color: #666; font-size: 14px;">
                Jika Anda memiliki pertanyaan atau memerlukan bantuan, silakan hubungi kami melalui email atau telepon yang tertera di sistem.
            </p>

            <p style="margin-top: 20px;">
                Terima kasih atas perhatian dan kerjasamanya.<br>
                <strong>Admin Tools Assets Management System.</strong>
            </p>
        </div>

        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh sistem. Mohon tidak membalas email ini.</p>
            <p>&copy; {{ date('Y') }} Sistem Manajemen Peminjaman Alat. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
