<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminder Pengembalian Alat</title>
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
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
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
            border-left: 4px solid #17a2b8;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .info-box h3 {
            margin-top: 0;
            color: #17a2b8;
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
            background-color: #17a2b8;
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
            background-color: #d1ecf1;
            border-left: 4px solid #17a2b8;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .alert-box p {
            margin: 5px 0;
            color: #0c5460;
        }
        .tanggal-kembali {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
        }
        .tanggal-kembali h3 {
            margin: 0 0 10px 0;
            color: #856404;
        }
        .tanggal-kembali .tanggal {
            font-size: 24px;
            font-weight: bold;
            color: #ffc107;
        }
        .alat-list {
            margin: 20px 0;
        }
        .alat-item {
            background-color: #f8f9fa;
            padding: 12px;
            margin: 8px 0;
            border-radius: 5px;
            border-left: 3px solid #17a2b8;
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
            background-color: #17a2b8;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        table th {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #dee2e6;
            color: #555;
        }
        table td {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        table tfoot td {
            font-weight: bold;
            background-color: #f8f9fa;
            border-top: 2px solid #dee2e6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔔 Reminder Pengembalian Alat</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Jatuh Tempo Besok</p>
        </div>

        <div class="content">
            <p>Yth. <strong>{{ $peminjaman->nama_peminjam }}</strong>,</p>

            <p>Kami mengingatkan bahwa peminjaman alat Anda <strong style="color: #17a2b8;">akan jatuh tempo BESOK</strong>.</p>

            <div class="tanggal-kembali">
                <h3>⏰ Tanggal Pengembalian</h3>
                <div class="tanggal">
                    {{ $peminjaman->tanggal_kembali_rencana->isoFormat('dddd, D MMMM Y') }}
                </div>
                <p style="margin: 10px 0 0 0; color: #856404; font-weight: bold;">(BESOK)</p>
            </div>

            <div class="info-box">
                <h3>📋 Informasi Peminjam</h3>
                <div class="info-item">
                    <strong>Nama</strong>: {{ $peminjaman->nama_peminjam }}
                </div>
                <div class="info-item">
                    <strong>NIP</strong>: {{ $peminjaman->nip_peminjam }}
                </div>
                <div class="info-item">
                    <strong>Departemen</strong>: {{ $peminjaman->departemen_peminjam }}
                </div>
                <div class="info-item">
                    <strong>Email</strong>: {{ $peminjaman->email }}
                </div>
            </div>

            <h3 style="color: #17a2b8; margin-top: 30px;">🔑 Kode Peminjaman:</h3>
            <div class="kode-peminjaman">
                {{ $peminjaman->kode_peminjaman }}
            </div>
            <p style="text-align: center; color: #666; font-size: 14px;">
                <em>Gunakan kode ini untuk pengembalian alat</em>
            </p>

            <div class="info-box">
                <h3>📅 Informasi Tanggal</h3>
                <div class="info-item">
                    <strong>Tanggal Peminjaman</strong>: {{ $peminjaman->tanggal_pinjam->isoFormat('dddd, D MMMM Y') }}
                </div>
                <div class="info-item">
                    <strong>Tanggal Harus Kembali</strong>:
                    <span style="color: #17a2b8; font-weight: bold;">
                        {{ $peminjaman->tanggal_kembali_rencana->isoFormat('dddd, D MMMM Y') }} (BESOK)
                    </span>
                </div>
                <div class="info-item">
                    <strong>Keperluan</strong>: {{ $peminjaman->keperluan }}
                </div>
            </div>

            <div class="info-box">
                <h3>📦 Alat yang Dipinjam</h3>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Alat</th>
                            <th style="width: 100px; text-align: center;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjaman->details as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $detail->alat->nama_alat ?? 'N/A' }}</strong><br>
                                <small style="color: #666;">{{ $detail->alat->kode_alat ?? '-' }}</small>
                            </td>
                            <td style="text-align: center;">{{ $detail->jumlah }} unit</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">Total Alat</td>
                            <td style="text-align: center;">{{ $peminjaman->total_jumlah }} unit</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="alert-box">
                <p><strong>💡 Perhatian!</strong></p>
                <p>Mohon untuk mengembalikan alat sesuai jadwal untuk menghindari keterlambatan.</p>
                <p>Keterlambatan pengembalian dapat mempengaruhi peminjaman Anda selanjutnya.</p>
            </div>

            <h3 style="color: #17a2b8; margin-top: 30px;">📝 Cara Pengembalian:</h3>
            <ol style="line-height: 2;">
                <li>Kunjungi halaman pengembalian alat</li>
                <li>Masukkan <strong>Kode Peminjaman</strong>: {{ $peminjaman->kode_peminjaman }}</li>
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
                Jika Anda memiliki pertanyaan atau memerlukan bantuan, silakan hubungi kami melalui email a
