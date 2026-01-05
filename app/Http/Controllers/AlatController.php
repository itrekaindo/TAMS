<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;
use App\Services\AlatImportService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AlatController extends Controller
{
    public function index(Request $request)
    {
        $query = Alat::query();

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_alat', 'like', "%{$search}%")
                  ->orWhere('kode_alat', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        // Filter by kondisi
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $alats = $query->latest()->paginate(15);

        // Get unique categories for filter
        $kategoris = Alat::select('kategori')
            ->distinct()
            ->whereNotNull('kategori')
            ->pluck('kategori');

        return view('alat.index', compact('alats', 'kategoris'));
    }

    public function create()
    {
        return view('alat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_alat' => 'required|string|unique:alats,kode_alat|max:50',
            'nama_alat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jumlah_total' => 'required|integer|min:1',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat,maintenance',
            'kategori' => 'nullable|string|max:100',
            'lokasi' => 'nullable|string|max:255'
        ]);

        $data = $request->all();
        $data['jumlah_tersedia'] = $request->jumlah_total;

        Alat::create($data);

        return redirect()->route('alat.index')
            ->with('success', 'Data alat berhasil ditambahkan!');
    }

    public function show(Alat $alat)
    {
        // Load peminjaman melalui peminjamanDetails
        $peminjamanAktif = $alat->peminjamanDetails()
            ->whereHas('peminjaman', function($q) {
                $q->where('status', 'dipinjam');
            })
            ->with('peminjaman.peminjam')
            ->latest()
            ->take(10)
            ->get();

        $peminjamanSelesai = $alat->peminjamanDetails()
            ->whereHas('peminjaman', function($q) {
                $q->where('status', 'dikembalikan');
            })
            ->with('peminjaman.peminjam')
            ->latest()
            ->take(10)
            ->get();

        // Gabungkan untuk ditampilkan di view (opsional)
        $peminjamans = $peminjamanAktif->merge($peminjamanSelesai)->sortByDesc('peminjaman.tanggal_pinjam')->take(10);

        // Statistik
        $totalPeminjaman = $alat->peminjamanDetails()->count();
        $sedangDipinjam = $alat->peminjamanDetails()
            ->whereHas('peminjaman', fn($q) => $q->where('status', 'dipinjam'))
            ->sum('jumlah'); // total unit yang sedang dipinjam
        $sudahDikembalikan = $alat->peminjamanDetails()
            ->whereHas('peminjaman', fn($q) => $q->where('status', 'dikembalikan'))
            ->sum('jumlah'); // total unit yang sudah dikembalikan

        return view('alat.show', compact(
            'alat',
            'peminjamans',
            'totalPeminjaman',
            'sedangDipinjam',
            'sudahDikembalikan'
        ));
    }

    public function edit(Alat $alat)
    {
        return view('alat.edit', compact('alat'));
    }

    public function update(Request $request, Alat $alat)
    {
        $request->validate([
            'kode_alat' => 'required|string|max:50|unique:alats,kode_alat,' . $alat->id,
            'nama_alat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jumlah_total' => 'required|integer|min:1',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat,maintenance',
            'kategori' => 'nullable|string|max:100',
            'lokasi' => 'nullable|string|max:255'
        ]);

        // Hitung jumlah unit yang sedang dipinjam (aktif)
        $dipinjam = $alat->peminjamanDetails()
            ->whereHas('peminjaman', fn($q) => $q->where('status', 'dipinjam'))
            ->sum('jumlah');

        // Validasi: jumlah_total baru tidak boleh kurang dari yang sedang dipinjam
        if ($request->jumlah_total < $dipinjam) {
            return back()->with('error', 'Jumlah total tidak boleh kurang dari jumlah yang sedang dipinjam (' . $dipinjam . ' unit)!')
                ->withInput();
        }

        // Hitung jumlah_tersedia baru
        $jumlahTersediaBaru = $request->jumlah_total - $dipinjam;

        $alat->update([
            'kode_alat' => $request->kode_alat,
            'nama_alat' => $request->nama_alat,
            'deskripsi' => $request->deskripsi,
            'jumlah_total' => $request->jumlah_total,
            'jumlah_tersedia' => $jumlahTersediaBaru,
            'kondisi' => $request->kondisi,
            'kategori' => $request->kategori,
            'lokasi' => $request->lokasi,
        ]);

        return redirect()->route('alat.index')
            ->with('success', 'Data alat berhasil diupdate!');
    }

    public function destroy(Alat $alat)
    {
        // Cek apakah masih ada peminjaman aktif
        $activePeminjaman = $alat->peminjamanDetails()
            ->whereHas('peminjaman', fn($q) => $q->where('status', 'dipinjam'))
            ->count();

        if ($activePeminjaman > 0) {
            return back()->with('error', 'Tidak dapat menghapus alat yang masih dipinjam!');
        }

        $alat->delete();

        return redirect()->route('alat.index')
            ->with('success', 'Data alat berhasil dihapus!');
    }

    // Additional method for stock adjustment
    public function adjustStock(Request $request, Alat $alat)
    {
        $request->validate([
            'adjustment_type' => 'required|in:add,subtract',
            'adjustment_amount' => 'required|integer|min:1',
            'reason' => 'required|string'
        ]);

        // Hitung jumlah yang sedang dipinjam
        $dipinjam = $alat->peminjamanDetails()
            ->whereHas('peminjaman', fn($q) => $q->where('status', 'dipinjam'))
            ->sum('jumlah');

        $amount = $request->adjustment_amount;

        if ($request->adjustment_type === 'add') {
            $alat->jumlah_total += $amount;
            $alat->jumlah_tersedia += $amount;
        } else {
            // Pastikan tidak mengurangi stok di bawah jumlah yang sedang dipinjam
            if ($alat->jumlah_total - $amount < $dipinjam) {
                return back()->with('error', 'Pengurangan stok tidak boleh membuat total stok kurang dari jumlah yang sedang dipinjam (' . $dipinjam . ' unit)!');
            }
            $alat->jumlah_total -= $amount;
            $alat->jumlah_tersedia -= $amount;
        }

        $alat->save();

        return back()->with('success', 'Stok alat berhasil disesuaikan!');
    }

    public function importForm()
    {
        return view('alat.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ], [
            'file.required' => 'File Excel wajib diupload',
            'file.mimes' => 'File harus berformat Excel (xlsx, xls)',
            'file.max' => 'Ukuran file maksimal 2MB',
        ]);

        try {
            $file = $request->file('file');

            // Gunakan getRealPath() untuk mendapatkan path temporary PHP
            $filePath = $file->getRealPath();

            // Log untuk debugging
            Log::info('Import file', [
                'original_name' => $file->getClientOriginalName(),
                'path' => $filePath,
                'exists' => file_exists($filePath)
            ]);

            // Import
            $importService = new AlatImportService();
            $result = $importService->import($filePath);

            if (!$result['success']) {
                return redirect()
                    ->back()
                    ->with('error', 'Import gagal: ' . $result['message'])
                    ->withInput();
            }

            $successCount = $result['successCount'];
            $failedCount = $result['failedCount'];
            $errors = $result['errors'];

            if ($failedCount > 0) {
                $errorMsg = implode('<br>', array_slice($errors, 0, 5));
                if (count($errors) > 5) {
                    $errorMsg .= '<br>... dan ' . (count($errors) - 5) . ' error lainnya';
                }

                session()->flash('warning', "Import selesai dengan peringatan:<br>✓ Berhasil: {$successCount} data<br>✗ Gagal: {$failedCount} data<br><br>{$errorMsg}");
            } else {
                session()->flash('success', "✓ Import berhasil! {$successCount} data alat telah ditambahkan/diperbarui.");
            }

            return redirect()->route('alat.index');

        } catch (\Exception $e) {
            Log::error('Import error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function downloadTemplate()
    {
        $filePath = public_path('templates/template_import_alat.xlsx');

        if (file_exists($filePath)) {
                return response()->download($filePath, 'Template_Import_Alat.xlsx');
            }

        return redirect()
            ->back()
            ->with('error', 'Template file tidak ditemukan!');
    }
}

