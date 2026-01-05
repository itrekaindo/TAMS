@extends('layouts.app')

@section('title', 'Pengembalian Alat')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Pengembalian Alat</h1>
    <p class="text-gray-600 mb-6">Silakan pilih peminjaman yang ingin Anda kembalikan:</p>

    <div class="space-y-4">
        @forelse ($peminjamanAktif as $p)
            <a href="{{ route('peminjaman.kembalikan', $p->id) }}"
               class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                <div class="font-medium">{{ $p->kode_peminjaman }}</div>
                <div class="text-sm text-gray-600">{{ $p->nama_alat }} — {{ $p->nama_lengkap }}</div>
                <div class="text-xs text-gray-500">Dipinjam: {{ $p->tanggal_pinjam?->format('d M Y') }}</div>
            </a>
        @empty
            <div class="text-center py-8 text-gray-500">
                Tidak ada peminjaman aktif saat ini.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        <a href="{{ route('landing') }}" class="text-blue-600 hover:underline">&larr; Kembali ke Beranda</a>
    </div>
</div>
@endsection
