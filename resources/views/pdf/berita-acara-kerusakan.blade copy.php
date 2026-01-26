<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Berita Acara Kerusakan - {{ $nomorBA }}</title>

    <style>
        /* ==================== RESET & BASE ==================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
            background: #fff;
        }

        /* ==================== PAGE CONTAINER ==================== */
        .page {
            position: relative;
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: white;
            display: flex;
            flex-direction: column;
        }

        /* ==================== HEADER & FOOTER ==================== */
        .header-wrapper {
            width: 100%;
            height: auto;
            overflow: hidden;
            flex-shrink: 0;
        }

        .header-img {
            width: 100%;
            height: auto;
            display: block;
        }

        .footer-wrapper {
            width: 100%;
            height: auto;
            overflow: hidden;
            flex-shrink: 0;
            margin-top: auto;
            position: fixed;
            bottom: 0;
        }

        .footer-img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* ==================== CONTENT AREA ==================== */
        .content-area {
            flex: 1;
            padding: 15mm 20mm 10mm 20mm;
        }

        /* ==================== TYPOGRAPHY ==================== */
        .text-center {
            text-align: center;
        }

        .text-justify {
            text-align: justify;
        }

        .font-bold {
            font-weight: bold;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .underline {
            text-decoration: underline;
        }

        .mt-2 {
            margin-top: 6px;
        }

        .mt-3 {
            margin-top: 10px;
        }

        .mt-4 {
            margin-top: 14px;
        }

        .mb-2 {
            margin-bottom: 6px;
        }

        .mb-3 {
            margin-bottom: 10px;
        }

        .mb-4 {
            margin-bottom: 14px;
        }

        h1 {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 8px;
        }

        h2 {
            font-size: 13pt;
            font-weight: bold;
            margin-bottom: 6px;
        }

        h3 {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 6px;
        }

        p {
            margin-bottom: 6px;
        }

        /* ==================== TABLES ==================== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0 12px 0;
            font-size: 10pt;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: top;
        }

        th {
            background-color: #e8e8e8;
            text-align: center;
            font-weight: bold;
            font-size: 10pt;
        }

        /* Data Table (No Border) */
        .data-table {
            border: none;
        }

        .data-table td {
            border: none;
            padding: 2px 0;
            font-size: 10.5pt;
        }

        .data-table td:first-child {
            width: 110px;
            font-weight: bold;
        }

        .data-table td:nth-child(2) {
            width: 15px;
            text-align: center;
        }

        /* ==================== SECTIONS ==================== */
        .section {
            margin-bottom: 12px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 6px;
            padding-bottom: 2px;
            border-bottom: 1px solid #000;
        }

        /* Kronologi Box */
        .kronologi-box {
            min-height: 60px;
            padding: 8px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 10pt;
            word-wrap: break-word;        /* Memecah kata panjang */
            overflow-wrap: break-word;    /* Alternatif modern */
            word-break: break-word;       /* Memecah kata jika terlalu panjang */
            white-space: normal;
        }

        .kronologi-box p {
            margin: 0;
            line-height: 1.5;
        }

        /* ==================== TINDAK LANJUT ==================== */
        .tindak-lanjut-grid {
            display: table;
            width: 100%;
            margin: 8px 0;
        }

        .tindak-lanjut-row {
            display: table-row;
        }

        .tindak-lanjut-cell {
            display: table-cell;
            width: 25%;
            padding: 4px 6px;
            font-size: 10pt;
        }

        .checkbox {
            display: inline-block;
            width: 11px;
            height: 11px;
            border: 1.5px solid #000;
            vertical-align: middle;
            margin-right: 5px;
        }

        /* ==================== SIGNATURE SECTION ==================== */
        .signature-section {
            margin-top: 25px;
            page-break-inside: avoid;
        }

        .signature-grid {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .signature-row {
            display: table-row;
        }

        .signature-cell {
            display: table-cell;
            width: 33.333%;
            text-align: center;
            vertical-align: top;
            padding: 0 8px;
        }

        .signature-title {
            font-weight: bold;
            font-size: 10.5pt;
            margin-bottom: 50px;
        }

        .signature-line {
            border-bottom: 1.5px solid #000;
            width: 150px;
            margin: 0 auto 5px auto;
        }

        .signature-name {
            font-size: 10pt;
            margin-top: 5px;
        }

        /* ==================== PERNYATAAN ==================== */
        .pernyataan-box {
            padding: 8px 10px;
            background: #f5f5f5;
            border-left: 3px solid #666;
            font-style: italic;
            font-size: 10pt;
            margin: 10px 0;
        }

        /* ==================== PRINT SPECIFIC ==================== */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .page {
                margin: 0;
                width: 210mm;
                min-height: 297mm;
                page-break-after: always;
            }

            .content-area {
                page-break-inside: avoid;
            }

            .signature-section,
            .section {
                page-break-inside: avoid;
            }
        }
    </style>

    {{-- Auto Print Script untuk langsung membuka dialog print (PDF) --}}
    <script>
        window.onload = function() {
            // Trigger print dialog otomatis saat halaman dimuat
            window.print();
        }
    </script>
</head>

<body>
    <div class="page">
        <!-- ==================== HEADER ==================== -->
        @if ($headerImage)
            <div class="header-wrapper">
                <img src="{{ $headerImage }}" class="header-img" alt="Header">
            </div>
        @endif

        <!-- ==================== CONTENT ==================== -->
        <div class="content-area">
            <!-- Judul -->
            <div class="text-center mb-4">
                <h2 class="underline">BERITA ACARA KERUSAKAN ALAT</h2>
            </div>

            <!-- Nomor BA -->
            <div class="text-center mb-3">
                <p class="font-bold">{{ $nomorBA }}</p>
            </div>

            <!-- Pembuka -->
            <div class="section">
                <p class="text-justify">
                    Pada hari ini <strong>{{ $tanggalBA->isoFormat('dddd') }}</strong>,
                    tanggal <strong>{{ $tanggalBA->isoFormat('D MMMM Y') }}</strong>,
                    telah dilaporkan kerusakan tools yang dipinjam dengan data sebagai berikut:
                </p>
            </div>

            <!-- Data Peminjam -->
            <div class="section">
                <div class="section-title">Data Peminjam</div>
                <table class="data-table">
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>{{ $peminjaman->nama_peminjam }}</td>
                    </tr>
                    <tr>
                        <td>NIP / ID</td>
                        <td>:</td>
                        <td>{{ $peminjaman->nip_peminjam }}</td>
                    </tr>
                    <tr>
                        <td>Departemen</td>
                        <td>:</td>
                        <td>{{ $peminjaman->departemen_peminjam }}</td>
                    </tr>
                    <tr>
                        <td>Kode Peminjaman</td>
                        <td>:</td>
                        <td>{{ $peminjaman->kode_peminjaman }}</td>
                    </tr>
                </table>
            </div>

            <!-- Data Tools Rusak -->
            <div class="section">
                <div class="section-title">Data Tools yang Mengalami Kerusakan</div>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 30px;">No</th>
                            <th style="width: 80px;">Kode Tools</th>
                            <th>Nama Tools</th>
                            <th style="width: 50px;">Jumlah</th>
                            <th style="width: 70px;">Kondisi Awal</th>
                            <th style="width: 70px;">Kondisi Akhir</th>
                            <th style="width: 120px;">Jenis Kerusakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($alatRusak) > 0)
                            @foreach ($alatRusak as $index => $item)
                                <tr>
                                    <td style="text-align: center;">{{ $index + 1 }}</td>
                                    <td>{{ $item['kode_alat'] }}</td>
                                    <td>{{ $item['nama_alat'] }}</td>
                                    <td style="text-align: center;">{{ $item['jumlah'] }}</td>
                                    <td style="text-align: center;">
                                        {{ ucfirst(str_replace('_', ' ', $item['kondisi_awal'])) }}</td>
                                    <td style="text-align: center;">
                                        {{ ucfirst(str_replace('_', ' ', $item['kondisi_akhir'])) }}</td>
                                    <td>{{ $item['keterangan'] ?: '-' }}</td>
                                </tr>
                            @endforeach
                        @else
                            @foreach ($peminjaman->details as $index => $detail)
                                <tr>
                                    <td style="text-align: center;">{{ $index + 1 }}</td>
                                    <td>{{ $detail->kode_alat }}</td>
                                    <td>{{ $detail->nama_alat }}</td>
                                    <td style="text-align: center;">{{ $detail->jumlah }}</td>
                                    <td style="text-align: center;">
                                        {{ ucfirst(str_replace('_', ' ', $detail->kondisi_alat)) }}</td>
                                    <td style="text-align: center;">...............</td>
                                    <td>............................................</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Kronologi -->
            <div class="section">
                <div class="section-title">Kronologi Singkat</div>
                <div class="kronologi-box">
                    @if (isset($kronologi) && $kronologi)
                        {!! nl2br(e($kronologi)) !!}
                    @else
                        <p style="color: #888; font-style: italic;">
                            Jelaskan secara singkat kronologi kejadian yang menyebabkan kerusakan alat...
                        </p>
                    @endif
                </div>
            </div>

            <!-- Tindak Lanjut -->
            <div class="section">
                <div class="section-title">Tindak Lanjut</div>
                <div class="tindak-lanjut-grid">
                    <div class="tindak-lanjut-row">
                        <div class="tindak-lanjut-cell">
                            <span class="checkbox"></span> Perbaikan
                        </div>
                        <div class="tindak-lanjut-cell">
                            <span class="checkbox"></span> Penggantian
                        </div>
                        <div class="tindak-lanjut-cell">
                            <span class="checkbox"></span> Klaim ke Peminjam
                        </div>
                        <div class="tindak-lanjut-cell">
                            <span class="checkbox"></span> Tidak dapat diperbaiki
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pernyataan -->
            <div class="pernyataan-box">
                <p>
                    Dengan ini dinyatakan bahwa tools tersebut <strong>mengalami kerusakan saat masa peminjaman</strong>
                    dan akan ditindaklanjuti sesuai ketentuan perusahaan yang berlaku.
                </p>
            </div>

            <!-- Tanda Tangan -->
            <div class="signature-section">
                <div class="signature-grid">
                    <div class="signature-row">
                        <!-- Kolom 1: Tools Keeper -->
                        <div class="signature-cell">
                            <p class="signature-title">Tools Keeper</p>
                            <div class="signature-line"></div>
                            <p class="signature-name">(.....................................)</p>
                        </div>

                        <!-- Kolom 2: Mengetahui -->
                        <div class="signature-cell">
                            <p class="signature-title">Mengetahui</p>
                            <div class="signature-line"></div>
                            <p class="signature-name">(.....................................)</p>
                        </div>

                        <!-- Kolom 3: Peminjam Tools -->
                        <div class="signature-cell">
                            <p class="signature-title">Peminjam Tools</p>
                            <div class="signature-line"></div>
                            <p class="signature-name font-bold">{{ $peminjaman->nama_peminjam }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== FOOTER ==================== -->
        @if ($footerImage)
            <div class="footer-wrapper">
                <img src="{{ $footerImage }}" class="footer-img" alt="Footer">
            </div>
        @endif
    </div>
</body>

</html>
