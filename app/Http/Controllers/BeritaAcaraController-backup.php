<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

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

        // Get kronologi dari request
        $kronologi = $request->kronologi;

        // Build array alat rusak dengan detail lengkap dari database
        $alatRusak = [];
        foreach ($alatRusakRaw as $item) {
            $detail = PeminjamanDetail::find($item['detail_id']);

            if ($detail) {
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

        // Generate nomor BA
        $nomorBA = '.../REKA/BA/PPO/.../' . now()->year;

        $data = [
            'peminjaman' => $peminjaman,
            'alatRusak' => $alatRusak,
            'kronologi' => $kronologi,
            'nomorBA' => $nomorBA,
            'tanggalBA' => now(),
        ];

        $pdf = Pdf::loadView('pdf.berita-acara-kerusakan', $data);
        $pdf->setPaper('A4', 'portrait');

        $fileName = 'Berita_Acara_Kerusakan_' . $peminjaman->kode_peminjaman . '_' . now()->format('YmdHis') . '.pdf';

        return $pdf->download($fileName);
    }

    public function previewBeritaAcara($peminjamanId)
    {
        $peminjaman = Peminjaman::with(['details.alat', 'peminjam'])->findOrFail($peminjamanId);

        // Untuk preview, gunakan semua alat
        $alatRusak = [];

        $nomorBA = '.../REKA/BA/PPO/.../' . now()->year;

        $data = [
            'peminjaman' => $peminjaman,
            'alatRusak' => $alatRusak,
            'nomorBA' => $nomorBA,
            'tanggalBA' => now(),
        ];

        $pdf = Pdf::loadView('pdf.berita-acara-kerusakan', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('preview.pdf');
    }
}
