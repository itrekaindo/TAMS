<?php

// namespace App\Http\Controllers;

// use App\Models\Alat;
// use App\Models\Peminjam;
// use App\Models\Peminjaman;
// use Illuminate\Http\Request;

// class DashboardController extends Controller
// {
//     public function index()
//     {
//         // Statistics
//         $totalAlat = Alat::count();
//         $totalPeminjam = Peminjam::count();
//         $totalPeminjaman = Peminjaman::count();
//         $peminjamanAktif = Peminjaman::where('status', 'dipinjam')->count();

//         // Recent Peminjaman (dengan eager loading details)
//         $peminjamanTerbaru = Peminjaman::with(['details.alat', 'peminjam'])
//             ->latest()
//             ->take(10)
//             ->get();

//         return view('dashboard', compact(
//             'totalAlat',
//             'totalPeminjam',
//             'totalPeminjaman',
//             'peminjamanAktif',
//             'peminjamanTerbaru'
//         ));
//     }
// }
namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjam;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Tanggal untuk perhitungan
        $today = Carbon::today();
        $thisMonthStart = Carbon::now()->startOfMonth();
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // ==========================================
        // STATISTIK UTAMA
        // ==========================================

        // Total Alat (Count dari tabel alat)
        $totalAlat = Alat::count();
        $totalAlatLastMonth = Alat::where('created_at', '<=', $lastMonthEnd)->count();
        $totalAlatGrowth = $this->calculateGrowth($totalAlat, $totalAlatLastMonth);

        // Total Peminjam
        $totalPeminjam = Peminjam::count();
        $totalPeminjamLastMonth = Peminjam::where('created_at', '<=', $lastMonthEnd)->count();
        $totalPeminjamGrowth = $this->calculateGrowth($totalPeminjam, $totalPeminjamLastMonth);

        // Total Peminjaman (All time)
        $totalPeminjaman = Peminjaman::count();
        $totalPeminjamanLastMonth = Peminjaman::where('created_at', '<=', $lastMonthEnd)->count();
        $totalPeminjamanGrowth = $this->calculateGrowth($totalPeminjaman, $totalPeminjamanLastMonth);

        // Peminjaman Aktif (status = dipinjam)
        $peminjamanAktif = Peminjaman::where('status', 'dipinjam')->count();
        $peminjamanAktifLastMonth = Peminjaman::where('status', 'dipinjam')
            ->where('created_at', '<=', $lastMonthEnd)
            ->count();
        $peminjamanAktifGrowth = $this->calculateGrowth($peminjamanAktif, $peminjamanAktifLastMonth);

        // Peminjaman Terlambat
        $peminjamanTerlambat = Peminjaman::where('status', 'dipinjam')
            ->where('tanggal_kembali_rencana', '<', $today)
            ->count();

        // Peminjaman Hari Ini
        $peminjamanHariIni = Peminjaman::whereDate('created_at', $today)->count();

        // ==========================================
        // STATISTIK ALAT
        // ==========================================

        // Total Unit Alat (Sum dari jumlah_total)
        $totalAlatUnit = Alat::sum('jumlah_total');

        // Alat Tersedia & Dipinjam
        $alatTersedia = Alat::sum('jumlah_tersedia');
        $alatDipinjam = $totalAlatUnit - $alatTersedia;

        // Persentase
        $persenTersedia = $totalAlatUnit > 0 ? ($alatTersedia / $totalAlatUnit) * 100 : 0;
        $persenDipinjam = $totalAlatUnit > 0 ? ($alatDipinjam / $totalAlatUnit) * 100 : 0;

        // Kondisi Alat
        $alatBaik = Alat::where('kondisi', 'baik')->count();
        $alatRusakRingan = Alat::where('kondisi', 'rusak_ringan')->count();
        $alatRusakBerat = Alat::where('kondisi', 'rusak_berat')->count();
        $alatRusak = $alatRusakRingan + $alatRusakBerat;
        $alatMaintenance = Alat::where('kondisi', 'maintenance')->count();

        // ==========================================
        // PEMINJAMAN TERBARU (10 Latest)
        // ==========================================

        $peminjamanTerbaru = Peminjaman::with(['details', 'peminjam'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // ==========================================
        // DEPARTEMEN TERBANYAK
        // ==========================================

        $departemenTerbanyak = Peminjaman::select('departemen', DB::raw('count(*) as total'))
            ->groupBy('departemen')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // ==========================================
        // GRAFIK DATA (Optional - untuk future use)
        // ==========================================

        // Peminjaman per bulan (6 bulan terakhir)
        $grafikPeminjaman = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $count = Peminjaman::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $grafikPeminjaman[] = [
                'bulan' => $month->format('M Y'),
                'total' => $count
            ];
        }

        return view('dashboard', compact(
            // Statistik Utama
            'totalAlat',
            'totalAlatGrowth',
            'totalPeminjam',
            'totalPeminjamGrowth',
            'totalPeminjaman',
            'totalPeminjamanGrowth',
            'peminjamanAktif',
            'peminjamanAktifGrowth',
            'peminjamanTerlambat',
            'peminjamanHariIni',

            // Statistik Alat
            'totalAlatUnit',
            'alatTersedia',
            'alatDipinjam',
            'persenTersedia',
            'persenDipinjam',
            'alatBaik',
            'alatRusak',
            'alatMaintenance',

            // Data Transaksi
            'peminjamanTerbaru',
            'departemenTerbanyak',
            'grafikPeminjaman'
        ));
    }

    /**
     * Calculate growth percentage
     */
    private function calculateGrowth($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        $growth = (($current - $previous) / $previous) * 100;
        return round($growth, 1);
    }
}
