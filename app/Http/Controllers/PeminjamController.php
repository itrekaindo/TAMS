<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use Illuminate\Http\Request;

class PeminjamController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjam::query()
            ->withCount('peminjamans')
            ->with(['peminjamans' => function($q) {
                $q->where('status', 'dipinjam')
                ->with('alat')
                ->latest();
            }]);

        // Search
        if ($request->has('search')) {
            $query->search($request->search);
        }

        $peminjams = $query->latest()->paginate(15);

        return view('peminjam.index', compact('peminjams'));
    }

    public function create()
    {
        return view('peminjam.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nip' => 'required|string|unique:peminjam,nip|max:50',
            'departemen' => 'required|string|max:255',
            'email' => 'required|email|unique:peminjam,email',
            'telepon' => 'required|string|max:20'
        ]);

        Peminjam::create($request->all());

        return redirect()->route('peminjam.index')
            ->with('success', 'Data peminjam berhasil ditambahkan!');
    }

    public function show(Peminjam $peminjam)
    {
        $peminjam->load('peminjamans.alat');
        return view('peminjam.show', compact('peminjam'));
    }

    public function edit(Peminjam $peminjam)
    {
        return view('peminjam.edit', compact('peminjam'));
    }

    public function update(Request $request, Peminjam $peminjam)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nip' => 'required|string|max:50|unique:peminjam,nip,' . $peminjam->id,
            'departemen' => 'required|string|max:255',
            'email' => 'required|email|unique:peminjam,email,' . $peminjam->id,
            'telepon' => 'required|string|max:20'
        ]);

        $peminjam->update($request->all());

        return redirect()->route('peminjam.index')
            ->with('success', 'Data peminjam berhasil diupdate!');
    }

    public function destroy(Peminjam $peminjam)
    {
        // Cek apakah masih ada peminjaman aktif
        $activePeminjaman = $peminjam->peminjamans()
            ->where('status', 'dipinjam')
            ->count();

        if ($activePeminjaman > 0) {
            return back()->with('error', 'Tidak dapat menghapus peminjam yang masih memiliki peminjaman aktif!');
        }

        $peminjam->delete();

        return redirect()->route('peminjam.index')
            ->with('success', 'Data peminjam berhasil dihapus!');
    }

    // API endpoint untuk get peminjam detail
    public function getPeminjamDetail($id)
    {
        $peminjam = Peminjam::findOrFail($id);
        return response()->json($peminjam);
    }
}
