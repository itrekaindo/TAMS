@extends('layouts.app')

@section('title', 'Data Peminjam')
@section('page-title', 'Data Peminjam')
@section('page-subtitle', 'Kelola data peminjam dan riwayat transaksi')

@section('content')
    <div class="space-y-6">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm">
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-blue-600 transition-colors font-medium">
                <i class="bi bi-house-door"></i>
                Dashboard
            </a>
            <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
            <span class="text-gray-900 font-semibold">Data Peminjam</span>
        </nav>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Total Peminjam --}}
            <div
                class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                <div
                    class="absolute top-0 right-0 w-24 h-24 bg-blue-500/5 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500">
                </div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-3">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <i class="bi bi-people text-white text-xl"></i>
                        </div>
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total</span>
                    </div>
                    <p class="text-3xl font-black text-gray-900 mb-1">{{ $peminjams->total() }}</p>
                    <p class="text-sm text-gray-500 font-medium">Peminjam Terdaftar</p>
                </div>
                <div
                    class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500">
                </div>
            </div>

            {{-- Aktif Meminjam --}}
            <div
                class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                <div
                    class="absolute top-0 right-0 w-24 h-24 bg-yellow-500/5 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500">
                </div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-3">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <i class="bi bi-hourglass-split text-white text-xl"></i>
                        </div>
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Aktif</span>
                    </div>
                    <p class="text-3xl font-black text-gray-900 mb-1">
                        {{ $peminjams->filter(fn($p) => $p->peminjamans->where('status', 'dipinjam')->count() > 0)->count() }}
                    </p>
                    <p class="text-sm text-gray-500 font-medium">Sedang Meminjam</p>
                </div>
                <div
                    class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-yellow-500 to-orange-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500">
                </div>
            </div>

            {{-- Total Peminjaman --}}
            <div
                class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                <div
                    class="absolute top-0 right-0 w-24 h-24 bg-green-500/5 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500">
                </div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-3">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <i class="bi bi-journal-check text-white text-xl"></i>
                        </div>
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Transaksi</span>
                    </div>
                    <p class="text-3xl font-black text-gray-900 mb-1">
                        {{ \App\Models\Peminjaman::count() }}
                    </p>
                    <p class="text-sm text-gray-500 font-medium">Semua Transaksi</p>
                </div>
                <div
                    class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-green-500 to-emerald-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500">
                </div>
            </div>

            {{-- Departemen --}}
            <div
                class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                <div
                    class="absolute top-0 right-0 w-24 h-24 bg-purple-500/5 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500">
                </div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-3">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <i class="bi bi-building text-white text-xl"></i>
                        </div>
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Unit</span>
                    </div>
                    <p class="text-3xl font-black text-gray-900 mb-1">
                        {{ \App\Models\Peminjam::distinct('departemen')->count('departemen') }}
                    </p>
                    <p class="text-sm text-gray-500 font-medium">Departemen Aktif</p>
                </div>
                <div
                    class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-500 to-pink-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500">
                </div>
            </div>
        </div>

        {{-- Main Content Card --}}
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-6 py-5 border-b border-gray-100">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-1.5 h-8 bg-gradient-to-b from-blue-600 to-indigo-600 rounded-full"></div>
                            <h2 class="text-2xl font-black text-gray-900">Daftar Peminjam</h2>
                        </div>
                        <p class="text-sm text-gray-500 font-medium ml-6">Data peminjam yang pernah melakukan transaksi</p>
                    </div>

                    {{-- Search --}}
                    <div class="relative w-full lg:w-96">
                        <input type="text" id="searchInput" placeholder="Cari nama, NIP, departemen..."
                            class="w-full pl-11 pr-4 py-2.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium transition-all hover:border-gray-300">
                        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                @if ($peminjams->isEmpty())
                    <div class="text-center py-20">
                        <div
                            class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl mb-6 shadow-inner">
                            <i class="bi bi-people text-5xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Data Peminjam</h3>
                        <p class="text-gray-500 mb-6 max-w-md mx-auto">
                            Data peminjam akan otomatis terdaftar saat melakukan peminjaman pertama kali
                        </p>
                        <a href="{{ route('peminjaman.create') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg hover:shadow-blue-500/50 transition-all font-semibold">
                            <i class="bi bi-plus-circle text-lg"></i>
                            <span>Buat Peminjaman Baru</span>
                        </a>
                    </div>
                @else
                    <table class="min-w-full" id="peminjamTable">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100">
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">
                                    Peminjam
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">
                                    Kontak
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-black text-gray-600 uppercase tracking-wider">
                                    Statistik
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">
                                    Peminjaman Aktif
                                </th>
                                {{-- [TAMBAHAN] Header kolom Aksi --}}
                                <th class="px-6 py-4 text-center text-xs font-black text-gray-600 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @foreach ($peminjams as $peminjam)
                                <tr
                                    class="group hover:bg-gradient-to-r hover:from-blue-50/30 hover:to-indigo-50/30 transition-all duration-300">
                                    {{-- Peminjam Info --}}
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="relative">
                                                <div
                                                    class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-lg shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                    {{ strtoupper(substr($peminjam->nama_lengkap, 0, 1)) }}
                                                </div>
                                                <div
                                                    class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white">
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="font-bold text-gray-900 truncate text-base">
                                                    {{ $peminjam->nama_lengkap }}</p>
                                                <div class="flex items-center gap-2 mt-1 flex-wrap">
                                                    <code
                                                        class="inline-flex items-center gap-1 text-xs font-mono font-bold bg-gray-100 px-2.5 py-1 rounded-lg text-gray-700 group-hover:bg-blue-100 group-hover:text-blue-700 transition-colors">
                                                        <i class="bi bi-person-badge"></i>
                                                        {{ $peminjam->nip }}
                                                    </code>
                                                    <span
                                                        class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 bg-purple-100 text-purple-700 rounded-lg">
                                                        <i class="bi bi-building"></i>
                                                        {{ $peminjam->departemen }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kontak --}}
                                    <td class="px-6 py-5">
                                        <div class="space-y-2">
                                            @if ($peminjam->email)
                                                <div class="flex items-center gap-2">
                                                    <div
                                                        class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                        <i class="bi bi-envelope-fill text-blue-600 text-sm"></i>
                                                    </div>
                                                    <a href="mailto:{{ $peminjam->email }}"
                                                        class="text-sm font-semibold text-blue-600 hover:text-blue-700 truncate">
                                                        {{ $peminjam->email }}
                                                    </a>
                                                </div>
                                            @endif
                                            @if ($peminjam->telepon)
                                                <div class="flex items-center gap-2">
                                                    <div
                                                        class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                        <i class="bi bi-telephone-fill text-green-600 text-sm"></i>
                                                    </div>
                                                    <a href="tel:{{ $peminjam->telepon }}"
                                                        class="text-sm font-semibold text-gray-700 hover:text-green-600 transition-colors">
                                                        {{ $peminjam->telepon }}
                                                    </a>
                                                </div>
                                            @endif
                                            @if (!$peminjam->email && !$peminjam->telepon)
                                                <div class="flex items-center gap-2 text-gray-400">
                                                    <i class="bi bi-dash-circle text-lg"></i>
                                                    <span class="text-sm italic">Tidak ada kontak</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Statistik --}}
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col items-center gap-3">
                                            {{-- Total Peminjaman --}}
                                            <div class="text-center">
                                                <p class="text-xs font-bold text-gray-500 mb-1.5">TOTAL PINJAM</p>
                                                <div
                                                    class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-xl font-black text-xl shadow-lg">
                                                    {{ $peminjam->peminjamans_count ?? 0 }}
                                                </div>
                                            </div>

                                            {{-- Status --}}
                                            @php
                                                $aktif = $peminjam->peminjamans->where('status', 'dipinjam')->count();
                                            @endphp
                                            @if ($aktif > 0)
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-black bg-gradient-to-r from-yellow-400 to-orange-400 text-white shadow-lg shadow-yellow-500/30">
                                                    <i class="bi bi-clock-fill"></i>
                                                    {{ $aktif }} Aktif
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-black bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg shadow-green-500/30">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    Clear
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Peminjaman Aktif --}}
                                    <td class="px-6 py-5">
                                        @php
                                            $peminjamanAktif = $peminjam->peminjamans->where('status', 'dipinjam');
                                        @endphp

                                        @if ($peminjamanAktif->count() > 0)
                                            <div class="space-y-2">
                                                @foreach ($peminjamanAktif->take(3) as $pinjam)
                                                    <div
                                                        class="flex items-center justify-between gap-3 bg-gradient-to-r from-yellow-50 to-orange-50 px-3 py-2.5 rounded-xl border border-yellow-100 hover:shadow-md transition-all group/item">
                                                        <a href="{{ route('peminjaman.show', $pinjam->id) }}"
                                                            class="font-mono text-sm font-bold text-blue-600 hover:text-blue-700 truncate group-hover/item:underline">
                                                            {{ $pinjam->kode_peminjaman }}
                                                        </a>
                                                        @if ($pinjam->isLate())
                                                            <span
                                                                class="flex-shrink-0 inline-flex items-center gap-1 px-2 py-1 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-lg text-xs font-black shadow-md animate-pulse">
                                                                <i class="bi bi-exclamation-circle-fill"></i>
                                                                Terlambat
                                                            </span>
                                                        @else
                                                            <span
                                                                class="flex-shrink-0 inline-flex items-center gap-1 px-2 py-1 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-lg text-xs font-black shadow-md">
                                                                <i class="bi bi-clock"></i>
                                                                Berjalan
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endforeach

                                                @if ($peminjamanAktif->count() > 3)
                                                    <div
                                                        class="text-center py-2 px-3 bg-gray-50 rounded-lg border border-gray-200">
                                                        <p class="text-xs font-bold text-gray-600">
                                                            <i class="bi bi-three-dots"></i>
                                                            +{{ $peminjamanAktif->count() - 3 }} peminjaman lainnya
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <div
                                                class="flex items-center justify-center gap-2 py-4 px-3 bg-gray-50 rounded-xl border border-gray-100">
                                                <div
                                                    class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                                    <i class="bi bi-check-circle-fill text-green-600 text-lg"></i>
                                                </div>
                                                <div class="text-left">
                                                    <p class="text-sm font-bold text-gray-700">Tidak Ada</p>
                                                    <p class="text-xs text-gray-500">Peminjaman Aktif</p>
                                                </div>
                                            </div>
                                        @endif
                                    </td>

                                    {{-- [TAMBAHAN] Kolom Aksi --}}
                                    <td class="px-6 py-5">
                                        <div class="flex items-center justify-center">
                                            <a href="{{ route('peminjam.edit', $peminjam->id) }}"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-amber-400 to-orange-400 hover:from-amber-500 hover:to-orange-500 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg hover:shadow-orange-500/30 transition-all duration-300 group/btn">
                                                <i class="bi bi-pencil-square text-sm group-hover/btn:rotate-12 transition-transform duration-300"></i>
                                                Edit
                                            </a>
                                        </div>

                                        {{-- Hapus --}}
                                        {{-- <form action="{{ route('peminjam.destroy', $peminjam->id) }}" method="POST"
                                            class="inline-block ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg hover:shadow-red-500/30 transition-all duration-300 group/btn"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus peminjam ini?')">
                                                <i class="bi bi-trash-fill text-sm group-hover/btn:rotate-12 transition-transform duration-300"></i>
                                                Hapus
                                            </button>
                                        </form> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            {{-- Pagination --}}
            @if ($peminjams->hasPages())
                <div class="px-6 py-5 border-t border-gray-100 bg-gray-50/50">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-gray-600 font-medium">
                            Menampilkan
                            <span class="font-black text-gray-900">{{ $peminjams->firstItem() }}</span>
                            sampai
                            <span class="font-black text-gray-900">{{ $peminjams->lastItem() }}</span>
                            dari
                            <span class="font-black text-gray-900">{{ $peminjams->total() }}</span>
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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Auto Register Info --}}
            <div
                class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 rounded-2xl p-6 shadow-xl">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>
                <div class="relative">
                    <div class="flex items-start gap-4 mb-4">
                        <div
                            class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            <i class="bi bi-info-circle-fill text-white text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-blue-100 mb-1">AUTO-REGISTER</p>
                            <p class="text-white font-medium text-sm leading-relaxed">
                                Peminjam otomatis terdaftar saat melakukan peminjaman pertama
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Departemen Terbanyak --}}
            <div
                class="relative overflow-hidden bg-gradient-to-br from-green-600 via-emerald-600 to-teal-600 rounded-2xl p-6 shadow-xl">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>
                <div class="relative">
                    <div class="flex items-start gap-4 mb-4">
                        <div
                            class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            <i class="bi bi-graph-up-arrow text-white text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-green-100 mb-1">DEPARTEMEN TERBANYAK</p>
                            <p class="text-white font-bold text-base leading-relaxed truncate">
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
            </div>

            {{-- Peminjam Teraktif --}}
            <div
                class="relative overflow-hidden bg-gradient-to-br from-purple-600 via-pink-600 to-rose-600 rounded-2xl p-6 shadow-xl">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>
                <div class="relative">
                    <div class="flex items-start gap-4 mb-4">
                        <div
                            class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            <i class="bi bi-star-fill text-white text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-purple-100 mb-1">PEMINJAM TERAKTIF</p>
                            <p class="text-white font-bold text-sm leading-relaxed">
                                @php
                                    $topPeminjam = \App\Models\Peminjam::withCount('peminjamans')
                                        ->orderBy('peminjamans_count', 'desc')
                                        ->first();
                                @endphp
                                @if ($topPeminjam)
                                    {{ Str::limit($topPeminjam->nama_lengkap, 20) }}
                                    <span class="block text-xs text-purple-100 mt-0.5">
                                        {{ $topPeminjam->peminjamans_count }} transaksi
                                    </span>
                                @else
                                    Belum ada data
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Search Functionality with Debounce
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('#peminjamTable tbody tr');
        let searchTimeout;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);

            const searchIcon = document.querySelector('#searchInput + i');
            searchIcon.classList.remove('bi-search');
            searchIcon.classList.add('bi-hourglass-split', 'animate-spin');

            searchTimeout = setTimeout(() => {
                const searchTerm = this.value.toLowerCase();

                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                        row.style.animation = 'fadeIn 0.3s ease-out';
                    } else {
                        row.style.display = 'none';
                    }
                });

                searchIcon.classList.remove('bi-hourglass-split', 'animate-spin');
                searchIcon.classList.add('bi-search');
            }, 300);
        });

        // Animate table rows on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        tableRows.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateY(20px)';
            row.style.transition = `all 0.5s ease ${index * 0.05}s`;
            observer.observe(row);
        });
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }
    </style>
@endpush
