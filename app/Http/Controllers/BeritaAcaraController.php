<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaAcaraController extends Controller
{
    public function generateBeritaAcara(Request $request, $peminjamanId)
    {
        // Validasi input
        $request->validate([
            'alat_rusak' => 'required|json',
            'kronologi' => 'required|string|min:20',
        ]);

        $peminjaman = Peminjaman::with(['details.alat', 'peminjam'])->findOrFail($peminjamanId);

        // Parse alat rusak dari request
        $alatRusakRaw = json_decode($request->alat_rusak, true);
        if (!is_array($alatRusakRaw)) {
            abort(400, 'Invalid alat_rusak format');
        }

        // Build array alat rusak dengan detail lengkap dari database
        $alatRusak = [];
        foreach ($alatRusakRaw as $item) {
            // Pastikan key ada
            if (!isset($item['detail_id'], $item['kondisi_akhir'])) {
                continue;
            }

            $detail = PeminjamanDetail::find($item['detail_id']);
            if ($detail && $detail->peminjaman_id === $peminjaman->id) {
                $alatRusak[] = [
                    'kode_alat' => $detail->kode_alat,
                    'nama_alat' => $detail->nama_alat,
                    'jumlah' => $detail->jumlah,
                    'kondisi_awal' => $detail->kondisi_alat,
                    'kondisi_akhir' => $item['kondisi_akhir'],
                    'keterangan' => $item['keterangan'] ?? '-',
                ];
            }
        }

        if (empty($alatRusak)) {
            return back()->withErrors(['alat_rusak' => 'Tidak ada alat rusak yang valid dipilih.']);
        }

        // Generate nomor BA (opsional: bisa disesuaikan dengan logika bisnis)
        $nomorBA = '______/REKA/BA/PPO/______/' . now()->year;

        $data = $this->preparePdfData($peminjaman, $alatRusak, $nomorBA, $request->kronologi);

        $pdf = Pdf::loadView('pdf.berita-acara-kerusakan', $data);
        $pdf->setPaper('A4', 'portrait');

        $fileName = 'Berita_Acara_Kerusakan_' . Str::slug($peminjaman->kode_peminjaman) . '_' . now()->format('YmdHis') . '.pdf';

        return $pdf->download($fileName);
        // return $pdf->stream($fileName);
    }

    public function previewBeritaAcara($peminjamanId)
    {
        $peminjaman = Peminjaman::with(['details.alat', 'peminjam'])->findOrFail($peminjamanId);

        // Untuk preview, tampilkan semua alat dalam peminjaman sebagai contoh
        $alatRusak = $peminjaman->details
            ->map(function ($detail) {
                return [
                    'kode_alat' => $detail->kode_alat,
                    'nama_alat' => $detail->nama_alat,
                    'jumlah' => $detail->jumlah,
                    'kondisi_awal' => $detail->kondisi_alat,
                    'kondisi_akhir' => 'Rusak', // contoh
                    'keterangan' => $detail->keterangan ?? 'Contoh keterangan',
                ];
            })
            ->all();

        $nomorBA = '   /REKA/BA/PPO/   /' . now()->year;
        $data = $this->preparePdfData($peminjaman, $alatRusak, $nomorBA, 'Kronologi contoh untuk preview.');

        $pdf = Pdf::loadView('pdf.berita-acara-kerusakan', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('preview_berita_acara.pdf');
    }

    /**
     * Prepare data for PDF view, including absolute paths for header/footer images.
     */
    protected function preparePdfData($peminjaman, $alatRusak, $nomorBA, $kronologi = null)
    {
        // Path absolut untuk gambar header & footer
        $headerPath = public_path('img/bheader.png');
        $footerPath = public_path('img/bfooter.png');

        // Pastikan file ada, jika tidak, biarkan kosong (opsional)
        $headerUrl = file_exists($headerPath) ? $headerPath : null;
        $footerUrl = file_exists($footerPath) ? $footerPath : null;

        return [
            'peminjaman' => $peminjaman,
            'alatRusak' => $alatRusak,
            'kronologi' => $kronologi,
            'nomorBA' => $nomorBA,
            'tanggalBA' => now(),
            'headerImage' => $headerUrl,
            'footerImage' => $footerUrl,
        ];
    }

    public function viewPDF(Request $request, $kode_peminjaman)
    {
        // Ambil data
        $peminjaman = Peminjaman::with(['details.alat', 'peminjam'])
            ->where('kode_peminjaman', $kode_peminjaman)
            ->firstOrFail();

        // Siapkan data alat contoh (untuk preview)
        $alatRusak = $peminjaman->details
            ->map(function ($detail) {
                return [
                    'kode_alat' => $detail->kode_alat,
                    'nama_alat' => $detail->nama_alat,
                    'jumlah' => $detail->jumlah,
                    'kondisi_awal' => $detail->kondisi_alat,
                    'kondisi_akhir' => ' Rusak', // contoh
                    'keterangan' => $detail->keterangan ?? 'Contoh keterangan',
                ];
            })
            ->all();

        // Data umum
        $data = [
            'peminjaman' => $peminjaman,
            'alatRusak' => $alatRusak,
            'kronologi' => 'Kronologi contoh untuk preview.',
            'nomorBA' => '______/REKA/BA/PPO/______/' . now()->year,
            'tanggalBA' => now(),
            'headerImage' => $this->getImageBase64('img/bheader.png'),
            'footerImage' => $this->getImageBase64('img/bfooter.png'),
        ];

        // Jika diminta download → generate PDF
        if ($request->get('download') === '1') {
            $pdf = Pdf::loadView('pdf.berita-acara-kerusakan', $data);
            $pdf->setPaper('A4', 'portrait');
            return $pdf->download("Berita_Acara_{$kode_peminjaman}.pdf");
        }

        // Jika tidak → tampilkan HTML biasa (preview)
        return view('pdf.berita-acara-kerusakan', $data);
    }

    private function getImageBase64($relativePath)
    {
        $path = public_path($relativePath);
        if (!file_exists($path)) {
            return null;
        }
        $mime = mime_content_type($path);
        $data = base64_encode(file_get_contents($path));
        return '' . $mime . ';base64,' . $data;
    }
}
