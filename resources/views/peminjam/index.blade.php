@extends('layouts.app')

@section('title', 'Data Peminjam')
@section('page-title', 'Data Peminjam')

@section('content')
{{-- Header Section with Stats --}}
<div class="mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        {{-- Total Peminjam --}}
        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Peminjam</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $peminjams->total() }}</p>
                    <p class="text-xs text-gray-400 mt-1">Terdaftar</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-people text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Aktif Meminjam --}}
        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Aktif Meminjam</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ $peminjams->filter(fn($p) => $p->peminjamans->where('status', 'dipinjam')->count() > 0)->count() }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Sedang Meminjam</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-hourglass-split text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Total Peminjaman --}}
        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Peminjaman</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ \App\Models\Peminjaman::count() }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Semua Transaksi</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-journal-check text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Departemen --}}
        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Departemen</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ \App\Models\Peminjam::distinct('departemen')->count('departemen') }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Unit Kerja</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="bi bi-building text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Main Content Card --}}
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    {{-- Header with Actions --}}
    <div class="px-6 py-4 border-b border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Daftar Peminjam</h2>
                <p class="text-sm text-gray-500 mt-1">Data peminjam yang pernah melakukan transaksi</p>
            </div>

            {{-- Search --}}
            <div class="relative">
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari nama, NIP, departemen..."
                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm w-full md:w-80"
                >
                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        @if($peminjams->isEmpty())
            <div class="text-center py-16">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                    <i class="bi bi-people text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Data Peminjam</h3>
                <p class="text-gray-500 mb-6">Data peminjam akan otomatis terdaftar saat melakukan peminjaman pertama kali</p>
                <a href="{{ route('peminjaman.create') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:shadow-lg transition-all">
                    <i class="bi bi-plus-circle"></i>
                    <span>Buat Peminjaman Baru</span>
                </a>
            </div>
        @else
            <table class="min-w-full divide-y divide-gray-100" id="peminjamTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Peminjam
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Kontak
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Statistik
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Peminjaman Aktif
                        </th>
                        {{-- <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Aksi
                        </th> --}}
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($peminjams as $peminjam)
                    <tr class="hover:bg-gray-50 transition-colors">
                        {{-- Peminjam Info --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                    {{ strtoupper(substr($peminjam->nama_lengkap, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-800 truncate">{{ $peminjam->nama_lengkap }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <code class="text-xs font-mono bg-gray-100 px-2 py-0.5 rounded text-gray-600">
                                            {{ $peminjam->nip }}
                                        </code>
                                        <span class="text-xs px-2 py-0.5 bg-purple-100 text-purple-700 rounded-full">
                                            {{ $peminjam->departemen }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Kontak --}}
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                @if($peminjam->email)
                                    <div class="flex items-center gap-2 text-sm">
                                        <i class="bi bi-envelope text-gray-400"></i>
                                        <a href="mailto:{{ $peminjam->email }}"
                                           class="text-blue-600 hover:underline truncate">
                                            {{ $peminjam->email }}
                                        </a>
                                    </div>
                                @endif
                                @if($peminjam->telepon)
                                    <div class="flex items-center gap-2 text-sm">
                                        <i class="bi bi-telephone text-gray-400"></i>
                                        <a href="tel:{{ $peminjam->telepon }}"
                                           class="text-gray-700 hover:text-blue-600">
                                            {{ $peminjam->telepon }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </td>

                        {{-- Statistik --}}
                        <td class="px-6 py-4">
                            <div class="flex flex-col items-center gap-2">
                                {{-- Total Peminjaman --}}
                                <div class="text-center">
                                    <p class="text-xs text-gray-500 mb-1">Total</p>
                                    <span class="inline-flex items-center justify-center w-10 h-10 bg-blue-100 text-blue-700 rounded-lg font-bold text-sm">
                                        {{ $peminjam->peminjamans_count ?? 0 }}
                                    </span>
                                </div>

                                {{-- Status --}}
                                @php
                                    $aktif = $peminjam->peminjamans->where('status', 'dipinjam')->count();
                                @endphp
                                @if($aktif > 0)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                        <i class="bi bi-clock-fill"></i>
                                        {{ $aktif }} Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        <i class="bi bi-check-circle-fill"></i>
                                        Clear
                                    </span>
                                @endif
                            </div>
                        </td>

                        {{-- Peminjaman Aktif --}}
                        <td class="px-6 py-4">
                            @php
                                $peminjamanAktif = $peminjam->peminjamans->where('status', 'dipinjam');
                            @endphp

                            @if($peminjamanAktif->count() > 0)
                                <div class="space-y-2">
                                    @foreach($peminjamanAktif->take(3) as $pinjam)
                                        <div class="flex items-center justify-between gap-2 text-sm bg-yellow-50 px-3 py-2 rounded-lg">
                                            <a href="{{ route('peminjaman.show', $pinjam->id) }}"
                                            class="font-mono font-medium text-blue-600 hover:underline truncate">
                                                {{ $pinjam->kode_peminjaman }}
                                            </a>
                                            @if($pinjam->isLate())
                                                <span class="flex-shrink-0 px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-semibold">
                                                    Terlambat
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach

                                    @if($peminjamanAktif->count() > 3)
                                        <div class="text-xs text-gray-500 text-center py-1">
                                            +{{ $peminjamanAktif->count() - 3 }} peminjaman lainnya
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="flex items-center justify-center gap-2 text-sm text-gray-400 py-2">
                                    <i class="bi bi-check-circle"></i>
                                    <span>Tidak ada peminjaman aktif</span>
                                </div>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        {{-- <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('peminjam.show', $peminjam->id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors"
                                   title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                    <span class="hidden lg:inline">Detail</span>
                                </a>

                                <a href="{{ route('peminjam.edit', $peminjam->id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-yellow-600 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors"
                                   title="Edit Data">
                                    <i class="bi bi-pencil"></i>
                                    <span class="hidden lg:inline">Edit</span>
                                </a>
                            </div>
                        </td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Pagination --}}
    @if($peminjams->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-600">
                    Menampilkan
                    <span class="font-semibold text-gray-800">{{ $peminjams->firstItem() }}</span>
                    sampai
                    <span class="font-semibold text-gray-800">{{ $peminjams->lastItem() }}</span>
                    dari
                    <span class="font-semibold text-gray-800">{{ $peminjams->total() }}</span>
                    peminjam
                </div>
                <div>
                    {{ $peminjams->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Quick Info Cards --}}
<div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="bi bi-info-circle text-white"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-800">Auto-Register</p>
                <p class="text-xs text-gray-600 mt-0.5">
                    Peminjam otomatis terdaftar saat melakukan peminjaman pertama
                </p>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border border-green-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="bi bi-graph-up text-white"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-800">Departemen Terbanyak</p>
                <p class="text-xs text-gray-600 mt-0.5">
                    @php
                        $topDept = \App\Models\Peminjam::select('departemen')
                            ->groupBy('departemen')
                            ->orderByRaw('COUNT(*) DESC')
                            ->first();
                    @endphp
                    {{ $topDept->departemen ?? 'Belum ada data' }}
                </p>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-4 border border-purple-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="bi bi-star-fill text-white"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-800">Peminjam Teraktif</p>
                <p class="text-xs text-gray-600 mt-0.5">
                    @php
                        $topPeminjam = \App\Models\Peminjam::withCount('peminjamans')
                            ->orderBy('peminjamans_count', 'desc')
                            ->first();
                    @endphp
                    {{ $topPeminjam ? $topPeminjam->nama_lengkap . ' (' . $topPeminjam->peminjamans_count . 'x)' : 'Belum ada data' }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Search Functionality
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('#peminjamTable tbody tr');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
</script>
@endsection
