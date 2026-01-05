<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Alat;
use App\Models\Peminjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['details.alat', 'peminjam']);

        // Filter status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_peminjaman', 'like', "%{$search}%")
                ->orWhere('nama_lengkap', 'like', "%{$search}%")
                ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        $peminjamans = $query->latest()->paginate(15);

        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $alats = Alat::where('jumlah_tersedia', '>', 0)->get();
        return view('peminjaman.create', compact('alats'));
    }

    public function store(Request $request)
    {
        // Validasi data umum
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nip' => 'required|string|max:50',
            'departemen' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:20',
            'tanggal_kembali_rencana' => 'required|date|after_or_equal:today',
            'keperluan' => 'required|string',
            'foto_peminjaman' => 'required|image|mimes:jpeg,png,jpg|max:2048',

            // Validasi array alat
            'alat' => 'required|array|min:1',
            'alat.*.alat_id' => 'required|exists:alats,id',
            'alat.*.jumlah' => 'required|integer|min:1',
            'alat.*.kondisi_alat' => 'required|in:baik,rusak_ringan,rusak_berat,maintenance',
        ]);

        DB::beginTransaction();

        try {
            // Validasi stok untuk setiap alat
            foreach ($request->alat as $itemAlat) {
                $alat = Alat::findOrFail($itemAlat['alat_id']);

                if ($alat->jumlah_tersedia < $itemAlat['jumlah']) {
                    throw new \Exception("Stok {$alat->nama_alat} tidak mencukupi! Tersedia: {$alat->jumlah_tersedia}");
                }
            }

            // Cek atau buat peminjam
            $peminjam = Peminjam::firstOrCreate(
                ['nip' => $request->nip],
                [
                    'nama_lengkap' => $request->nama_lengkap,
                    'departemen' => $request->departemen,
                    'email' => $request->email,
                    'telepon' => $request->telepon
                ]
            );

            if (!$peminjam->wasRecentlyCreated) {
                $peminjam->update([
                    'nama_lengkap' => $request->nama_lengkap,
                    'departemen' => $request->departemen,
                    'email' => $request->email,
                    'telepon' => $request->telepon
                ]);
            }

            // Generate kode peminjaman
            $kode = 'PJM-' . date('Ymd') . '-' . str_pad(
                Peminjaman::whereDate('created_at', today())->count() + 1,
                4,
                '0',
                STR_PAD_LEFT
            );

            // Upload foto
            // ✅ UPLOAD FOTO - MODIFIKASI BAGIAN INI
            $fotoPath = null;
            if ($request->hasFile('foto_peminjaman')) {
                $file = $request->file('foto_peminjaman');
                $extension = $file->getClientOriginalExtension();

                // Format: pinjam-YYYYMMDD-HHMMSS.ext
                $filename = 'pinjam-' . date('Ymd-His') . '.' . $extension;

                // Buat folder jika belum ada
                $destinationPath = public_path('photo/pinjam');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                // Pindahkan file ke public/photo/pinjam
                $file->move($destinationPath, $filename);

                // Simpan path relatif untuk database
                $fotoPath = 'photo/pinjam/' . $filename;
            }

            // Simpan peminjaman (header)
            $peminjaman = Peminjaman::create([
                'kode_peminjaman' => $kode,
                'peminjam_id' => $peminjam->id,
                'nama_lengkap' => $request->nama_lengkap,
                'nip' => $request->nip,
                'departemen' => $request->departemen,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'tanggal_pinjam' => now(),
                'keperluan' => $request->keperluan,
                'foto_peminjaman' => $fotoPath,
                'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
                'status' => 'dipinjam'
            ]);

            // Simpan detail peminjaman (items)
            foreach ($request->alat as $itemAlat) {
                $alat = Alat::findOrFail($itemAlat['alat_id']);

                // Simpan detail
                PeminjamanDetail::create([
                    'peminjaman_id' => $peminjaman->id,
                    'alat_id' => $alat->id,
                    'nama_alat' => $alat->nama_alat,
                    'kode_alat' => $alat->kode_alat,
                    'jumlah' => $itemAlat['jumlah'],
                    'kondisi_alat' => $itemAlat['kondisi_alat'],
                ]);

                // Update stok
                $alat->jumlah_tersedia -= $itemAlat['jumlah'];
                $alat->save();
            }

            DB::commit();

            return redirect()
                ->route('landing')
                ->with('success', 'Peminjaman berhasil dicatat dengan kode: ' . $kode . '. Silakan simpan kode ini untuk pengembalian.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['details.alat', 'peminjam']);
        return view('peminjaman.show', compact('peminjaman'));
    }

    // Method untuk halaman cari peminjaman (public)
    public function cariPeminjaman()
    {
        return view('pengembalian.cari');
    }

    // Method untuk proses cari peminjaman (public)
    public function prosesCariPeminjaman(Request $request)
    {
        $request->validate([
            'kode_peminjaman' => 'required|string'
        ]);

        $peminjaman = Peminjaman::where('kode_peminjaman', $request->kode_peminjaman)
            ->with(['details.alat', 'peminjam'])
            ->first();

        if (!$peminjaman) {
            return back()
                ->with('error', 'Kode peminjaman tidak ditemukan! Pastikan kode yang Anda masukkan benar.')
                ->withInput();
        }

        if ($peminjaman->status === 'dikembalikan') {
            return back()
                ->with('error', 'Peminjaman dengan kode ini sudah dikembalikan pada tanggal ' .
                    $peminjaman->tanggal_kembali_aktual->isoFormat('D MMMM Y'))
                ->withInput();
        }

        return redirect()->route('pengembalian.form', $peminjaman->kode_peminjaman);
    }

    // Method untuk menampilkan form pengembalian (public)
    public function formPengembalian($kode)
    {
        $peminjaman = Peminjaman::where('kode_peminjaman', $kode)
            ->with(['details.alat', 'peminjam'])
            ->firstOrFail();

        if ($peminjaman->status === 'dikembalikan') {
            return redirect()
                ->route('pengembalian.cari')
                ->with('error', 'Peminjaman ini sudah dikembalikan!');
        }

        return view('pengembalian.form', compact('peminjaman'));
    }

    // Method untuk submit pengembalian (public)
    public function submitPengembalian(Request $request, $id)
    {
        // Validasi untuk setiap detail alat
        $peminjaman = Peminjaman::with('details')->findOrFail($id);

        $rules = [
            'foto_pengembalian' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan_pengembalian' => 'nullable|string',
            'detail' => 'required|array',
        ];

        // Tambahkan validasi untuk setiap detail
        foreach ($peminjaman->details as $index => $detail) {
            $rules["detail.{$detail->id}.kondisi_alat_kembali"] = 'required|in:baik,rusak_ringan,rusak_berat,maintenance';
            $rules["detail.{$detail->id}.keterangan"] = 'nullable|string';
        }

        $request->validate($rules);

        if ($peminjaman->status === 'dikembalikan') {
            return redirect()
                ->route('landing')
                ->with('error', 'Peminjaman ini sudah dikembalikan!');
        }

        DB::beginTransaction();

        try {
            // ✅ UPLOAD FOTO PENGEMBALIAN - MODIFIKASI BAGIAN INI
            $fotoPath = null;
            if ($request->hasFile('foto_pengembalian')) {
                $file = $request->file('foto_pengembalian');
                $extension = $file->getClientOriginalExtension();

                // Format: kembali-YYYYMMDD-HHMMSS.ext
                $filename = 'kembali-' . date('Ymd-His') . '.' . $extension;

                // Buat folder jika belum ada
                $destinationPath = public_path('photo/kembali');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                // Pindahkan file ke public/photo/kembali
                $file->move($destinationPath, $filename);

                // Simpan path relatif untuk database
                $fotoPath = 'photo/kembali/' . $filename;
            }

            // Update peminjaman header
            $peminjaman->update([
                'tanggal_kembali_aktual' => now(),
                'foto_pengembalian' => $fotoPath,
                'keterangan_pengembalian' => $request->keterangan_pengembalian,
                'status' => 'dikembalikan'
            ]);

            // Update setiap detail dan stok alat
            foreach ($peminjaman->details as $detail) {
                $detailInput = $request->detail[$detail->id];

                // Update detail
                $detail->update([
                    'kondisi_alat_kembali' => $detailInput['kondisi_alat_kembali'],
                    'keterangan' => $detailInput['keterangan'] ?? null,
                ]);

                // Update stok alat
                $alat = $detail->alat;
                $alat->jumlah_tersedia += $detail->jumlah;

                // Update kondisi alat jika memburuk
                if ($detailInput['kondisi_alat_kembali'] !== 'baik') {
                    $alat->kondisi = $detailInput['kondisi_alat_kembali'];
                }

                $alat->save();
            }

            DB::commit();

            return redirect()
                ->route('landing')
                ->with('success', 'Pengembalian berhasil! Terima kasih telah mengembalikan alat tepat waktu.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    // Method untuk admin - kembalikan alat
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::with(['details.alat', 'peminjam'])->findOrFail($id);

        if ($peminjaman->status !== 'dipinjam') {
            return redirect()
                ->route('peminjaman.index')
                ->with('error', 'Peminjaman sudah dikembalikan!');
        }

        return view('peminjaman.kembalikan', compact('peminjaman'));
    }

    // Method untuk admin - proses kembalikan
    public function prosesKembalikan(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('details')->findOrFail($id);

        $rules = [
            'foto_pengembalian' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan_pengembalian' => 'nullable|string',
            'detail' => 'required|array',
        ];

        // Tambahkan validasi untuk setiap detail
        foreach ($peminjaman->details as $detail) {
            $rules["detail.{$detail->id}.kondisi_alat_kembali"] = 'required|in:baik,rusak_ringan,rusak_berat,maintenance';
            $rules["detail.{$detail->id}.keterangan"] = 'nullable|string';
        }

        $request->validate($rules);

        DB::beginTransaction();

        try {
            // Upload foto pengembalian
            $fotoPath = null;
            if ($request->hasFile('foto_pengembalian')) {
                $file = $request->file('foto_pengembalian');
                $filename = $peminjaman->kode_peminjaman . '_kembali_' . time() . '.' .
                    $file->getClientOriginalExtension();
                $fotoPath = $file->storeAs('pengembalian', $filename, 'public');
            }

            // Update peminjaman header
            $peminjaman->update([
                'tanggal_kembali_aktual' => now(),
                'foto_pengembalian' => $fotoPath,
                'keterangan_pengembalian' => $request->keterangan_pengembalian,
                'status' => 'dikembalikan'
            ]);

            // Update setiap detail dan stok alat
            foreach ($peminjaman->details as $detail) {
                $detailInput = $request->detail[$detail->id];

                // Update detail
                $detail->update([
                    'kondisi_alat_kembali' => $detailInput['kondisi_alat_kembali'],
                    'keterangan' => $detailInput['keterangan'] ?? null,
                ]);

                // Update stok alat
                $alat = $detail->alat;
                $alat->jumlah_tersedia += $detail->jumlah;

                // Update kondisi alat jika memburuk
                if ($detailInput['kondisi_alat_kembali'] !== 'baik') {
                    $alat->kondisi = $detailInput['kondisi_alat_kembali'];
                }

                $alat->save();
            }

            DB::commit();

            return redirect()
                ->route('peminjaman.index')
                ->with('success', 'Pengembalian berhasil dicatat!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    public function getItems($id)
    {
        try {
            $peminjaman = Peminjaman::with('details.alat')->findOrFail($id);

            return response()->json([
                'details' => $peminjaman->details->map(function($detail) {
                    return [
                        'id' => $detail->id,
                        'nama_alat' => $detail->nama_alat,
                        'kode_alat' => $detail->kode_alat,
                        'jumlah' => $detail->jumlah,
                        'kondisi_awal' => $detail->kondisi_alat,
                    ];
                }),
                'total_items' => $peminjaman->details->count(),
                'total_units' => $peminjaman->details->sum('jumlah'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Data tidak ditemukan',
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
