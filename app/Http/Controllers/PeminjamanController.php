<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\PeminjamanFotoPengembalian;
use App\Models\PeminjamanDokumen;
use App\Models\Alat;
use App\Models\Peminjam;
use App\Mail\PeminjamanBerhasilMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['details.alat', 'peminjam', 'fotoPengembalian', 'dokumen']);

        // Filter status - gunakan nilai yang benar
        if ($request->has('status') && $request->status != '') {
            $status = $request->status;

            // Support untuk filter khusus
            if ($status === 'aktif') {
                // Filter peminjaman yang masih aktif (belum selesai)
                $query->whereIn('status', ['dipinjam', 'sebagian_dikembalikan']);
            } elseif ($status === 'selesai') {
                // Filter peminjaman yang sudah selesai
                $query->where('status', 'dikembalikan');
            } else {
                // Filter berdasarkan status spesifik
                $query->where('status', $status);
            }
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_peminjaman', 'like', "%{$search}%")
                    ->orWhere('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        $peminjamans = $query->latest()->paginate(15);

        return view('peminjaman.index', compact('peminjamans'));
    }

    public function searchAlat(Request $request)
    {
        $search = $request->get('search', '');
        $page = $request->get('page', 1);

        // Query alat yang tersedia
        $query = Alat::where('jumlah_tersedia', '>', 0);

        // Filter berdasarkan search (nama atau kode)
        if ($search != '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama_alat', 'like', "%{$search}%")->orWhere('kode_alat', 'like', "%{$search}%");
            });
        }

        // Pagination
        $total = $query->count();
        $alats = $query->orderBy('nama_alat', 'asc')->get();

        // Format data untuk Choices.js
        $results = $alats->map(function ($alat) {
            // Format kondisi
            $kondisiText = ucfirst(str_replace('_', ' ', $alat->kondisi));

            return [
                'value' => $alat->id,
                'label' => "{$alat->nama_alat} ({$alat->kode_alat}) - Tersedia: {$alat->jumlah_tersedia} - Kondisi: {$kondisiText}",
                // Custom data untuk digunakan di frontend
                'customProperties' => [
                    'kode_alat' => $alat->kode_alat,
                    'nama_alat' => $alat->nama_alat,
                    'jumlah_tersedia' => $alat->jumlah_tersedia,
                    'kondisi' => $alat->kondisi,
                ],
            ];
        });

        return response()->json($results);
    }

    public function create(Request $request)
    {
        $alats = collect(); // Empty collection untuk AJAX mode
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
                    'telepon' => $request->telepon,
                ],
            );

            if (!$peminjam->wasRecentlyCreated) {
                $peminjam->update([
                    'nama_lengkap' => $request->nama_lengkap,
                    'departemen' => $request->departemen,
                    'email' => $request->email,
                    'telepon' => $request->telepon,
                ]);
            }

            // Generate kode peminjaman
            $kode = 'PJM-' . date('Ymd') . '-' . str_pad(Peminjaman::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

            // Upload foto
            $fotoPath = null;
            if ($request->hasFile('foto_peminjaman')) {
                $file = $request->file('foto_peminjaman');
                $extension = $file->getClientOriginalExtension();
                $filename = 'pinjam-' . date('Ymd-His') . '.' . $extension;

                $destinationPath = public_path('photo/pinjam');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $filename);
                $fotoPath = 'photo/pinjam/' . $filename;
            }

            // Simpan peminjaman (header) - HAPUS kolom foto_pengembalian dan surat_pernyataan
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
                'status' => 'dipinjam',
            ]);

            // Simpan detail peminjaman (items)
            foreach ($request->alat as $itemAlat) {
                $alat = Alat::findOrFail($itemAlat['alat_id']);

                PeminjamanDetail::create([
                    'peminjaman_id' => $peminjaman->id,
                    'alat_id' => $alat->id,
                    'nama_alat' => $alat->nama_alat,
                    'kode_alat' => $alat->kode_alat,
                    'jumlah' => $itemAlat['jumlah'],
                    'kondisi_alat' => $itemAlat['kondisi_alat'],
                    'jumlah_dikembalikan' => 0,
                    'status_item' => 'dipinjam'
                ]);

                // Update stok
                $alat->jumlah_tersedia -= $itemAlat['jumlah'];
                $alat->save();
            }

            DB::commit();

            // Kirim email konfirmasi
            try {
                Mail::to($request->email)->send(new PeminjamanBerhasilMail($peminjaman));
            } catch (\Exception $e) {
                Log::error('Gagal mengirim email peminjaman: ' . $e->getMessage());
            }

            return redirect()
                ->route('landing')
                ->with('success', 'Peminjaman berhasil dicatat dengan kode: ' . $kode . '. Silakan simpan kode ini untuk pengembalian.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['details.alat', 'peminjam', 'fotoPengembalian', 'dokumen']);
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function cariPeminjaman()
    {
        return view('pengembalian.cari');
    }

    public function prosesCariPeminjaman(Request $request)
    {
        $request->validate([
            'kode_peminjaman' => 'required|string',
        ]);

        $peminjaman = Peminjaman::where('kode_peminjaman', $request->kode_peminjaman)
            ->with(['details.alat', 'peminjam'])
            ->first();

        if (!$peminjaman) {
            return back()->with('error', 'Kode peminjaman tidak ditemukan! Pastikan kode yang Anda masukkan benar.')->withInput();
        }

        if ($peminjaman->status === 'dikembalikan') {
            return back()
                ->with('error', 'Peminjaman dengan kode ini sudah dikembalikan pada tanggal ' . $peminjaman->tanggal_kembali_aktual->isoFormat('D MMMM Y'))
                ->withInput();
        }

        return redirect()->route('pengembalian.form', $peminjaman->kode_peminjaman);
    }

    public function formPengembalian($kode)
    {
        $peminjaman = Peminjaman::where('kode_peminjaman', $kode)
            ->with(['details.alat', 'peminjam'])
            ->firstOrFail();

        if ($peminjaman->status === 'dikembalikan') {
            return redirect()
                ->route('pengembalian.cari')
                ->with('error', 'Peminjaman ini sudah dikembalikan sepenuhnya pada tanggal ' .
                       $peminjaman->tanggal_kembali_aktual->format('d M Y'));
        }

        // Filter hanya item yang masih ada sisa yang belum dikembalikan
        $itemsAvailable = $peminjaman->details->filter(function ($detail) {
            return $detail->jumlah_belum_kembali > 0;
        });

        if ($itemsAvailable->isEmpty()) {
            return redirect()
                ->route('pengembalian.cari')
                ->with('error', 'Semua alat sudah dikembalikan!');
        }

        return view('pengembalian.form', compact('peminjaman'));
    }

    /**
     * ✅ UPDATED: Submit pengembalian dengan multiple foto dan dokumen
     */
    public function submitPengembalian(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('details.alat')->findOrFail($id);

        // ✅ Validasi diperbaiki
        $rules = [
            'foto_pengembalian' => 'required|array|min:1',
            'foto_pengembalian.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan_foto.*' => 'nullable|string|max:255',

            'dokumen_ba' => 'nullable|array',
            'dokumen_ba.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'keterangan_dokumen.*' => 'nullable|string|max:255',

            'keterangan_pengembalian' => 'nullable|string|max:1000',
            'detail' => 'required|array|min:1',
        ];

        // Validasi untuk setiap item yang dikembalikan
        if ($request->has('detail')) {
            foreach ($request->detail as $detailId => $detailData) {
                $rules["detail.{$detailId}.jumlah_dikembalikan"] = 'required|integer|min:1';
                $rules["detail.{$detailId}.kondisi_alat_kembali"] = 'required|in:baik,rusak_ringan,rusak_berat,maintenance';
                $rules["detail.{$detailId}.keterangan"] = 'nullable|string|max:500';
            }
        }

        $customMessages = [
            'foto_pengembalian.required' => 'Foto pengembalian wajib diupload',
            'foto_pengembalian.array' => 'Format foto tidak valid',
            'foto_pengembalian.min' => 'Minimal 1 foto pengembalian harus diupload',
            'foto_pengembalian.*.required' => 'File foto tidak boleh kosong',
            'foto_pengembalian.*.image' => 'File harus berupa gambar',
            'foto_pengembalian.*.mimes' => 'Format foto harus JPEG, PNG, atau JPG',
            'foto_pengembalian.*.max' => 'Ukuran foto maksimal 2MB',

            'dokumen_ba.array' => 'Format dokumen tidak valid',
            'dokumen_ba.*.file' => 'File dokumen tidak valid',
            'dokumen_ba.*.mimes' => 'Format dokumen harus PDF, DOC, DOCX, atau gambar',
            'dokumen_ba.*.max' => 'Ukuran dokumen maksimal 5MB',

            'detail.required' => 'Pilih minimal 1 alat untuk dikembalikan',
            'detail.min' => 'Pilih minimal 1 alat untuk dikembalikan',
        ];

        $request->validate($rules, $customMessages);

        DB::beginTransaction();

        try {
            // 1. Validasi stok yang dikembalikan
            foreach ($request->detail as $detailId => $detailData) {
                $detail = PeminjamanDetail::findOrFail($detailId);
                $jumlahKembali = (int) $detailData['jumlah_dikembalikan'];
                $sisaBelumKembali = $detail->jumlah - $detail->jumlah_dikembalikan;

                if ($jumlahKembali > $sisaBelumKembali) {
                    throw new \Exception(
                        "Jumlah pengembalian untuk {$detail->nama_alat} melebihi sisa yang belum dikembalikan! " .
                        "Sisa yang belum dikembalikan: {$sisaBelumKembali}"
                    );
                }

                if ($jumlahKembali <= 0) {
                    throw new \Exception("Jumlah yang dikembalikan harus lebih dari 0!");
                }
            }

            // 2. Cek apakah ada kerusakan
            $adaKerusakan = false;
            foreach ($request->detail as $detailId => $detailData) {
                $detail = PeminjamanDetail::findOrFail($detailId);
                $kondisiKembali = $detailData['kondisi_alat_kembali'];

                if ($kondisiKembali !== $detail->kondisi_alat && $kondisiKembali !== 'baik') {
                    $adaKerusakan = true;
                    break;
                }
            }

            // 3. ✅ Validasi dokumen BA diperbaiki
            if ($adaKerusakan && !$request->hasFile('dokumen_ba')) {
                return back()
                    ->withInput()
                    ->withErrors(['dokumen_ba' => 'Berita acara kerusakan wajib diupload karena terdapat alat dengan kondisi rusak!']);
            }

            // 4. ✅ Upload MULTIPLE foto pengembalian (diperbaiki)
            if ($request->hasFile('foto_pengembalian')) {
                foreach ($request->file('foto_pengembalian') as $index => $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'kembali-' . $peminjaman->kode_peminjaman . '-' . date('Ymd-His') . '-' . ($index + 1) . '.' . $extension;

                    $destinationPath = public_path('photo/kembali');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $file->move($destinationPath, $filename);
                    $fotoPath = 'photo/kembali/' . $filename;

                    // ✅ Simpan dengan keterangan yang sesuai index
                    PeminjamanFotoPengembalian::create([
                        'peminjaman_id' => $peminjaman->id,
                        'foto_path' => $fotoPath,
                        'keterangan' => $request->input("keterangan_foto.{$index}") ?? null,
                        'tanggal_upload' => now(),
                    ]);
                }
            }

            // 5. ✅ Upload MULTIPLE dokumen BA (diperbaiki)
            if ($request->hasFile('dokumen_ba')) {
                foreach ($request->file('dokumen_ba') as $index => $file) {
                    $extension = $file->getClientOriginalExtension();
                    $originalName = $file->getClientOriginalName();
                    $filename = 'BA-' . $peminjaman->kode_peminjaman . '-' . date('Ymd-His') . '-' . ($index + 1) . '.' . $extension;

                    $destinationPath = public_path('berita_acara');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $file->move($destinationPath, $filename);
                    $dokumenPath = 'berita_acara/' . $filename;

                    // ✅ Simpan dengan keterangan yang sesuai index
                    PeminjamanDokumen::create([
                        'peminjaman_id' => $peminjaman->id,
                        'dokumen_path' => $dokumenPath,
                        'nama_dokumen' => $originalName,
                        'keterangan' => $request->input("keterangan_dokumen.{$index}") ?? null,
                        'tanggal_upload' => now(), // ✅ Tambahkan jika ada kolom ini
                    ]);

                    Log::info("Dokumen BA berhasil diupload", [
                        'peminjaman_id' => $peminjaman->id,
                        'filename' => $filename,
                        'path' => $dokumenPath
                    ]);
                }
            }

            // 6. Proses setiap item yang dikembalikan
            foreach ($request->detail as $detailId => $detailData) {
                $detail = PeminjamanDetail::with('alat')->findOrFail($detailId);
                $jumlahKembali = (int) $detailData['jumlah_dikembalikan'];

                // Update jumlah yang sudah dikembalikan
                $detail->jumlah_dikembalikan += $jumlahKembali;

                // Update kondisi dan keterangan
                $detail->kondisi_alat_kembali = $detailData['kondisi_alat_kembali'];

                // Append keterangan jika ada
                if (!empty($detailData['keterangan'])) {
                    $keteranganBaru = date('d/m/Y H:i') . ' - Pengembalian ' . $jumlahKembali . ' unit: ' . $detailData['keterangan'];
                    $detail->keterangan = $detail->keterangan
                        ? $detail->keterangan . "\n" . $keteranganBaru
                        : $keteranganBaru;
                }

                // Update status item
                if ($detail->jumlah_dikembalikan >= $detail->jumlah) {
                    $detail->status_item = 'dikembalikan';
                    $detail->tanggal_kembali_item = now();
                } elseif ($detail->jumlah_dikembalikan > 0) {
                    $detail->status_item = 'sebagian_dikembalikan';
                }

                $detail->save();

                // Update stok alat
                $alat = $detail->alat;
                $alat->jumlah_tersedia += $jumlahKembali;

                // Update kondisi alat jika memburuk
                if ($detailData['kondisi_alat_kembali'] !== 'baik') {
                    $alat->kondisi = $detailData['kondisi_alat_kembali'];
                }

                $alat->save();

                Log::info("Pengembalian item: {$detail->nama_alat}", [
                    'peminjaman_id' => $peminjaman->id,
                    'detail_id' => $detail->id,
                    'jumlah_dikembalikan' => $jumlahKembali,
                ]);
            }

            // 7. Update keterangan pengembalian di header
            if ($request->keterangan_pengembalian) {
                $keteranganBaru = date('d/m/Y H:i') . ' - ' . $request->keterangan_pengembalian;
                $peminjaman->keterangan_pengembalian = $peminjaman->keterangan_pengembalian
                    ? $peminjaman->keterangan_pengembalian . "\n" . $keteranganBaru
                    : $keteranganBaru;
                $peminjaman->save();
            }

            // 8. Update status peminjaman
            $peminjaman->updateStatusBasedOnReturns();

            DB::commit();

            // 9. Tentukan pesan sukses
            if ($peminjaman->status === 'dikembalikan') {
                $message = 'Pengembalian berhasil! Semua alat telah dikembalikan sepenuhnya. Terima kasih!';
            } else {
                $totalBelumKembali = $peminjaman->total_item_belum_kembali;
                $message = "Pengembalian sebagian berhasil! Masih ada {$totalBelumKembali} unit alat yang belum dikembalikan.";
            }

            return redirect()
                ->route('landing')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error submit pengembalian: ' . $e->getMessage(), [
                'peminjaman_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::with(['details.alat', 'peminjam'])->findOrFail($id);

        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->route('peminjaman.index')->with('error', 'Peminjaman sudah dikembalikan!');
        }
    }

    public function prosesKembalikan(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('details')->findOrFail($id);

        $rules = [
            'foto_pengembalian.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
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
            // ✅ Upload multiple foto pengembalian
            if ($request->hasFile('foto_pengembalian')) {
                foreach ($request->file('foto_pengembalian') as $index => $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'kembali-' . $peminjaman->kode_peminjaman . '-' . date('Ymd-His') . '-' . ($index + 1) . '.' . $extension;

                    $destinationPath = public_path('photo/kembali');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $file->move($destinationPath, $filename);
                    $fotoPath = 'photo/kembali/' . $filename;

                    PeminjamanFotoPengembalian::create([
                        'peminjaman_id' => $peminjaman->id,
                        'foto_path' => $fotoPath,
                        'tanggal_upload' => now(),
                    ]);
                }
            }

            // Update peminjaman header
            $peminjaman->keterangan_pengembalian = $request->keterangan_pengembalian;
            $peminjaman->save();

            // Update setiap detail dan stok alat
            foreach ($peminjaman->details as $detail) {
                $detailInput = $request->detail[$detail->id];

                // Update detail
                $detail->update([
                    'kondisi_alat_kembali' => $detailInput['kondisi_alat_kembali'],
                    'keterangan' => $detailInput['keterangan'] ?? null,
                    'jumlah_dikembalikan' => $detail->jumlah,
                    'status_item' => 'dikembalikan',
                    'tanggal_kembali_item' => now(),
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

            // Update status peminjaman
            $peminjaman->updateStatusBasedOnReturns();

            DB::commit();

            return redirect()->route('peminjaman.index')->with('success', 'Pengembalian berhasil dicatat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::with(['details.alat', 'fotoPengembalian', 'dokumen'])->findOrFail($id);

        // Cegah penghapusan jika masih dipinjam
        // if (in_array($peminjaman->status, ['dipinjam', 'sebagian_dikembalikan'])) {
        //     return redirect()
        //         ->route('peminjaman.index')
        //         ->with('error', 'Peminjaman yang masih aktif tidak dapat dihapus!');
        // }

        DB::beginTransaction();

        try {
            // Hapus file foto pengembalian
            foreach ($peminjaman->fotoPengembalian as $foto) {
                $fotoFullPath = public_path($foto->foto_path);
                if (file_exists($fotoFullPath)) {
                    unlink($fotoFullPath);
                }
                $foto->delete();
            }

            // Hapus file dokumen BA
            foreach ($peminjaman->dokumen as $dokumen) {
                $dokumenFullPath = public_path($dokumen->dokumen_path);
                if (file_exists($dokumenFullPath)) {
                    unlink($dokumenFullPath);
                }
                $dokumen->delete();
            }

            // Hapus foto peminjaman awal
            if ($peminjaman->foto_peminjaman) {
                $fotoPinjamPath = public_path($peminjaman->foto_peminjaman);
                if (file_exists($fotoPinjamPath)) {
                    unlink($fotoPinjamPath);
                }
            }

            // Hapus detail peminjaman
            $peminjaman->details()->delete();

            // Hapus header peminjaman
            $peminjaman->delete();

            DB::commit();

            return redirect()
                ->route('peminjaman.index')
                ->with('success', 'Data peminjaman berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error destroy peminjaman: ' . $e->getMessage(), [
                'peminjaman_id' => $id,
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->route('peminjaman.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function getItems($id)
    {
        try {
            $peminjaman = Peminjaman::with('details.alat')->findOrFail($id);

            return response()->json([
                'details' => $peminjaman->details->map(function ($detail) {
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
            return response()->json(
                [
                    'error' => 'Data tidak ditemukan',
                    'message' => $e->getMessage(),
                ],
                404,
            );
        }
    }

    public function extendPeminjaman(Request $request, $id)
    {
        $request->validate(
            [
                'tanggal_kembali_rencana_baru' => 'required|date|after:today',
            ],
            [
                'tanggal_kembali_rencana_baru.required' => 'Tanggal rencana baru wajib diisi',
                'tanggal_kembali_rencana_baru.date' => 'Format tanggal tidak valid',
                'tanggal_kembali_rencana_baru.after' => 'Tanggal harus lebih dari hari ini',
            ],
        );

        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'dipinjam' && $peminjaman->status !== 'sebagian_dikembalikan' && $peminjaman->status !== 'terlambat') {
            return back()->with('error', 'Hanya peminjaman yang masih aktif yang bisa diperpanjang.');
        }

        $tanggalBaru = \Carbon\Carbon::parse($request->tanggal_kembali_rencana_baru);
        $tanggalLama = $peminjaman->tanggal_kembali_rencana;

        if ($tanggalBaru->lte($tanggalLama)) {
            return back()->with('error', 'Tanggal rencana baru harus lebih dari tanggal rencana saat ini.');
        }

        try {
            DB::beginTransaction();

            $tanggalLamaFormatted = $tanggalLama->format('d M Y');
            $tanggalBaruFormatted = $tanggalBaru->format('d M Y');

            $peminjaman->tanggal_kembali_rencana = $tanggalBaru;
            $peminjaman->save();

            DB::commit();

            return redirect()
                ->route('peminjaman.show', $id)
                ->with('success', "Waktu peminjaman berhasil diperpanjang dari {$tanggalLamaFormatted} menjadi {$tanggalBaruFormatted}.");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error extend peminjaman: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat memperpanjang waktu peminjaman.');
        }
    }

    public function historiPengembalian($id)
    {
        $peminjaman = Peminjaman::with(['details.alat', 'peminjam', 'fotoPengembalian', 'dokumen'])->findOrFail($id);
        return view('peminjaman.histori-pengembalian', compact('peminjaman'));
    }
}
