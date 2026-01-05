@extends('layouts.app')

@section('title', 'Data Peminjaman')
@section('page-title', 'Data Peminjaman')
@section('page-subtitle', 'Kelola semua transaksi peminjaman alat')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm">
        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-blue-600 transition-colors font-medium">
            <i class="bi bi-house-door"></i>
            Dashboard
        </a>
        <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
        <span class="text-gray-900 font-semibold">Data Peminjaman</span>
    </nav>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total Peminjaman --}}
        <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/5 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="bi bi-journal-check text-white text-xl"></i>
                    </div>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total</span>
                </div>
                <p class="text-3xl font-black text-gray-900 mb-1">{{ $peminjamans->total() }}</p>
                <p class="text-sm text-gray-500 font-medium">Semua Transaksi</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
        </div>

        {{-- Sedang Dipinjam --}}
        <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="absolute top-0 right-0 w-24 h-24 bg-yellow-500/5 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="bi bi-hourglass-split text-white text-xl"></i>
                    </div>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Aktif</span>
                </div>
                <p class="text-3xl font-black text-gray-900 mb-1">
                    {{ \App\Models\Peminjaman::where('status', 'dipinjam')->count() }}
                </p>
                <p class="text-sm text-gray-500 font-medium">Belum Dikembalikan</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-yellow-500 to-orange-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
        </div>

        {{-- Sudah Dikembalikan --}}
        <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="absolute top-0 right-0 w-24 h-24 bg-green-500/5 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="bi bi-check-circle text-white text-xl"></i>
                    </div>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Selesai</span>
                </div>
                <p class="text-3xl font-black text-gray-900 mb-1">
                    {{ \App\Models\Peminjaman::where('status', 'dikembalikan')->count() }}
                </p>
                <p class="text-sm text-gray-500 font-medium">Sudah Kembali</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-green-500 to-emerald-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
        </div>

        {{-- Terlambat --}}
        <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="absolute top-0 right-0 w-24 h-24 bg-red-500/5 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="bi bi-exclamation-triangle text-white text-xl"></i>
                    </div>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Terlambat</span>
                </div>
                <p class="text-3xl font-black text-gray-900 mb-1">
                    {{ \App\Models\Peminjaman::where('status', 'dipinjam')
                        ->where('tanggal_kembali_rencana', '<', now())
                        ->count()
                    }}
                </p>
                <p class="text-sm text-gray-500 font-medium">Melewati Deadline</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-red-500 to-pink-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
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
                        <h2 class="text-2xl font-black text-gray-900">Daftar Peminjaman</h2>
                    </div>
                    <p class="text-sm text-gray-500 font-medium ml-6">Riwayat semua transaksi peminjaman alat</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    {{-- Filter Status --}}
                    <select id="filterStatus" class="px-8 py-2.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium transition-all hover:border-gray-300">
                        <option value="">Semua Status</option>
                        <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>

                    {{-- Search --}}
                    {{-- <div class="relative">
                        <input
                            type="text"
                            id="searchInput"
                            value="{{ request('search') }}"
                            placeholder="Cari kode, nama, NIP..."
                            class="pl-11 pr-4 py-2.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium transition-all hover:border-gray-300 w-full sm:w-64"
                        >
                        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
                    </div> --}}

                    {{-- Add Button --}}
                    <a href="{{ route('peminjaman.create') }}"
                       class="group inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg hover:shadow-blue-500/50 transition-all text-sm font-bold hover:-translate-y-0.5">
                        <i class="bi bi-plus-circle text-lg"></i>
                        <span>Tambah Peminjaman</span>
                        <i class="bi bi-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            @if($peminjamans->isEmpty())
                <div class="text-center py-20">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl mb-6 shadow-inner">
                        <i class="bi bi-inbox text-5xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Data Peminjaman</h3>
                    <p class="text-gray-500 mb-6 max-w-md mx-auto">Mulai dengan membuat transaksi peminjaman baru untuk mencatat aktivitas peminjaman alat</p>
                    <a href="{{ route('peminjaman.create') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg hover:shadow-blue-500/50 transition-all font-semibold">
                        <i class="bi bi-plus-circle text-lg"></i>
                        <span>Buat Peminjaman Baru</span>
                    </a>
                </div>
            @else
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">
                                Kode
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">
                                Peminjam
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">
                                Alat Dipinjam
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">
                                Tanggal Pinjam
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">
                                Tanggal Kembali
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-black text-gray-600 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-black text-gray-600 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-50">
                        @foreach($peminjamans as $peminjaman)
                        <tr class="group hover:bg-gradient-to-r hover:from-blue-50/30 hover:to-indigo-50/30 transition-all duration-300">
                            {{-- Kode --}}
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center">
                                        <i class="bi bi-hash text-blue-600 text-sm"></i>
                                    </div>
                                    <code class="text-xs font-mono font-bold bg-gray-100 px-2.5 py-1.5 rounded-lg text-gray-700 group-hover:bg-blue-100 group-hover:text-blue-700 transition-colors">
                                        {{ $peminjaman->kode_peminjaman }}
                                    </code>
                                </div>
                            </td>

                            {{-- Peminjam --}}
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <div class="w-11 h-11 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-base shadow-lg group-hover:scale-110 transition-transform duration-300">
                                            {{ strtoupper(substr($peminjaman->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white"></div>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-bold text-gray-900 truncate">{{ $peminjaman->nama_lengkap }}</p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="inline-flex items-center gap-1 text-xs text-gray-500">
                                                <i class="bi bi-person-badge"></i>
                                                {{ $peminjaman->nip }}
                                            </span>
                                            <span class="text-gray-300">•</span>
                                            <span class="inline-flex items-center gap-1 text-xs text-gray-500">
                                                <i class="bi bi-building"></i>
                                                {{ $peminjaman->departemen }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Alat yang Dipinjam --}}
                            <td class="px-6 py-5">
                                @if($peminjaman->details && $peminjaman->details->count() > 0)
                                    <div class="space-y-2">
                                        @foreach($peminjaman->details->take(2) as $detail)
                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-bold rounded-lg bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 transition-colors">
                                                    <i class="bi bi-box"></i>
                                                    <span class="max-w-[180px] truncate">{{ $detail->nama_alat }}</span>
                                                </span>
                                                <span class="inline-flex items-center px-2 py-1 text-xs font-black rounded-lg bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700">
                                                    ×{{ $detail->jumlah }}
                                                </span>
                                            </div>
                                        @endforeach

                                        @if($peminjaman->details->count() > 2)
                                            <button
                                                onclick="showAllItems({{ $peminjaman->id }})"
                                                class="inline-flex items-center gap-1 text-xs text-blue-600 hover:text-blue-700 font-bold hover:gap-2 transition-all">
                                                <span>+{{ $peminjaman->details->count() - 2 }} alat lainnya</span>
                                                <i class="bi bi-arrow-right"></i>
                                            </button>
                                        @endif

                                        <div class="flex items-center gap-2 pt-1">
                                            <div class="h-px flex-1 bg-gray-200"></div>
                                            <span class="text-xs text-gray-500 font-bold">
                                                <i class="bi bi-info-circle text-blue-500"></i>
                                                {{ $peminjaman->details->sum('jumlah') }} unit total
                                            </span>
                                            <div class="h-px flex-1 bg-gray-200"></div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400 italic">Tidak ada data alat</span>
                                @endif
                            </td>

                            {{-- Tanggal Pinjam --}}
                            <td class="px-6 py-5">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="bi bi-calendar-event text-blue-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
                                            <p class="text-xs text-gray-500">{{ $peminjaman->tanggal_pinjam->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Tanggal Kembali --}}
                            <td class="px-6 py-5">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                            <i class="bi bi-calendar-check text-orange-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}</p>
                                            @if($peminjaman->status === 'dipinjam')
                                                @if($peminjaman->isLate())
                                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-red-600">
                                                        <i class="bi bi-exclamation-circle-fill"></i>
                                                        Terlambat
                                                    </span>
                                                @else
                                                    <p class="text-xs text-gray-500">{{ $peminjaman->tanggal_kembali_rencana->diffForHumans() }}</p>
                                                @endif
                                            @else
                                                @if($peminjaman->tanggal_kembali_aktual)
                                                    <p class="text-xs text-green-600 font-semibold">
                                                        <i class="bi bi-check-circle"></i>
                                                        {{ $peminjaman->tanggal_kembali_aktual->format('d M Y') }}
                                                    </p>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-5 text-center">
                                @if($peminjaman->status === 'dikembalikan')
                                    <span class="inline-flex items-center gap-2 px-4 py-2 text-xs font-black rounded-xl bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg shadow-green-500/30">
                                        <i class="bi bi-check-circle-fill"></i>
                                        Dikembalikan
                                    </span>
                                @elseif($peminjaman->isLate())
                                    <span class="inline-flex items-center gap-2 px-4 py-2 text-xs font-black rounded-xl bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg shadow-red-500/30 animate-pulse">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        Terlambat
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 px-4 py-2 text-xs font-black rounded-xl bg-gradient-to-r from-yellow-400 to-orange-400 text-white shadow-lg shadow-yellow-500/30">
                                        <i class="bi bi-clock-fill"></i>
                                        Dipinjam
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-5">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('peminjaman.show', $peminjaman->id) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-bold text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-all hover:shadow-md"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    {{-- @if($peminjaman->status === 'dipinjam')
                                        <a href="{{ route('peminjaman.kembalikan', $peminjaman->id) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-bold text-green-600 bg-green-50 rounded-lg hover:bg-green-100 transition-all hover:shadow-md"
                                           title="Kembalikan">
                                            <i class="bi bi-arrow-return-left"></i>
                                        </a>
                                    @endif --}}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        {{-- Pagination --}}
        @if($peminjamans->hasPages())
            <div class="px-6 py-5 border-t border-gray-100 bg-gray-50/50">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-600 font-medium">
                        Menampilkan
                        <span class="font-black text-gray-900">{{ $peminjamans->firstItem() }}</span>
                        sampai
                        <span class="font-black text-gray-900">{{ $peminjamans->lastItem() }}</span>
                        dari
                        <span class="font-black text-gray-900">{{ $peminjamans->total() }}</span>
                        peminjaman
                    </div>
                    <div>
                        {{ $peminjamans->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Modal for All Items --}}
<div id="itemsModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-fadeIn">
    <div class="bg-white rounded-3xl shadow-2xl max-w-3xl w-full max-h-[85vh] overflow-hidden transform transition-all" onclick="event.stopPropagation()">
        {{-- Modal Header --}}
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-5 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-box-seam text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-gray-900">Detail Alat yang Dipinjam</h3>
                        <p class="text-sm text-gray-500 font-medium mt-0.5">Rincian lengkap alat dalam peminjaman ini</p>
                    </div>
                </div>
                <button onclick="closeModal()" class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
                    <i class="bi bi-x-lg text-xl"></i>
                </button>
            </div>
        </div>

        {{-- Modal Content --}}
        <div id="modalContent" class="p-6 overflow-y-auto max-h-[calc(85vh-120px)]">
            {{-- Loading State --}}
            <div class="flex items-center justify-center py-12">
                <div class="text-center">
                    <div class="w-16 h-16 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin mx-auto mb-4"></div>
                    <p class="text-gray-500 font-medium">Memuat data...</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Filter by status
    document.getElementById('filterStatus').addEventListener('change', function() {
        const status = this.value;
        const url = new URL(window.location.href);

        if (status) {
            url.searchParams.set('status', status);
        } else {
            url.searchParams.delete('status');
        }

        // Keep current page
        url.searchParams.set('page', '1');
        window.location.href = url.toString();
    });

    // Search functionality with debounce
    let searchTimeout;
    document.getElementById('searchInput').addEventListener('input', function() {
        clearTimeout(searchTimeout);

        const searchIcon = this.previousElementSibling;
        searchIcon.classList.remove('bi-search');
        searchIcon.classList.add('bi-hourglass-split');

        searchTimeout = setTimeout(() => {
            const search = this.value;
            const url = new URL(window.location.href);

            if (search) {
                url.searchParams.set('search', search);
            } else {
                url.searchParams.delete('search');
            }

            url.searchParams.set('page', '1');
            window.location.href = url.toString();
        }, 800);
    });

    function showAllItems(peminjamanId) {
        const modal = document.getElementById('itemsModal');
        const modalContent = document.getElementById('modalContent');

        // Show modal immediately
        modal.classList.remove('hidden');

        // Show loading state
        modalContent.innerHTML = `
            <div class="flex items-center justify-center py-12">
                <div class="text-center">
                    <div class="w-16 h-16 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin mx-auto mb-4"></div>
                    <p class="text-gray-500 font-medium">Memuat data...</p>
                </div>
            </div>
        `;

        // Fetch data via AJAX
        fetch(`/peminjaman/${peminjamanId}/items`)
            .then(response => {
                console.log('Response status:', response.status); // Debug log
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data); // Debug log

                if (!data.details || data.details.length === 0) {
                    modalContent.innerHTML = `
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                                <i class="bi bi-inbox text-4xl text-gray-400"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800 mb-2">Tidak Ada Data</h4>
                            <p class="text-gray-500">Tidak ada detail alat untuk peminjaman ini</p>
                        </div>
                    `;
                    return;
                }

                let html = '<div class="space-y-3">';

                data.details.forEach((detail, index) => {
                    const kondisiAwal = detail.kondisi_awal || 'Tidak dicatat';
                    const kondisiColor = {
                        'baik': 'bg-green-100 text-green-700',
                        'rusak_ringan': 'bg-yellow-100 text-yellow-700',
                        'rusak_berat': 'bg-red-100 text-red-700',
                        'maintenance': 'bg-blue-100 text-blue-700'
                    };
                    const colorClass = kondisiColor[kondisiAwal] || 'bg-purple-100 text-purple-700';

                    html += `
                        <div class="group flex items-center gap-4 p-4 bg-gradient-to-r from-gray-50 to-blue-50/30 rounded-2xl border border-gray-100 hover:shadow-md hover:border-blue-200 transition-all duration-300">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <span class="text-lg font-black text-white">${index + 1}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-gray-900 text-base mb-1">${detail.nama_alat || 'Nama tidak tersedia'}</p>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-semibold rounded-lg bg-blue-100 text-blue-700">
                                        <i class="bi bi-upc-scan"></i>
                                        ${detail.kode_alat || 'N/A'}
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-semibold rounded-lg ${colorClass}">
                                        <i class="bi bi-tools"></i>
                                        ${kondisiAwal.replace('_', ' ').toUpperCase()}
                                    </span>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="inline-flex items-center gap-1.5 px-4 py-2 text-base font-black rounded-xl bg-gradient-to-r from-orange-400 to-orange-500 text-white shadow-lg">
                                    <i class="bi bi-box"></i>
                                    <span>×${detail.jumlah || 0}</span>
                                </div>
                            </div>
                        </div>
                    `;
                });

                html += '</div>';

                // Summary Card
                html += `
                    <div class="mt-6 p-5 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-xl">
                        <div class="flex items-center justify-between text-white">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                    <i class="bi bi-info-circle text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-blue-100 font-medium">Total Ringkasan</p>
                                    <p class="text-2xl font-black">${data.total_units || 0} Unit</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-blue-100 font-medium">Jenis Alat</p>
                                <p class="text-2xl font-black">${data.total_items || 0}</p>
                            </div>
                        </div>
                    </div>
                `;

                modalContent.innerHTML = html;
            })
            .catch(error => {
                console.error('Error fetching items:', error); // Debug log
                modalContent.innerHTML = `
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 rounded-full mb-4">
                            <i class="bi bi-exclamation-triangle text-4xl text-red-600"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-800 mb-2">Gagal Memuat Data</h4>
                        <p class="text-gray-500 mb-2">Terjadi kesalahan saat mengambil data alat</p>
                        <p class="text-xs text-gray-400 mb-6">${error.message}</p>
                        <button onclick="showAllItems(${peminjamanId})" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-colors">
                            <i class="bi bi-arrow-clockwise"></i> Coba Lagi
                        </button>
                    </div>
                `;
            });
    }

    function closeModal() {
        const modal = document.getElementById('itemsModal');
        modal.classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('itemsModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });

    // Animate elements on scroll
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

    // Observe all table rows
    document.querySelectorAll('tbody tr').forEach((row, index) => {
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
        }
        to {
            opacity: 1;
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }

    /* Custom Scrollbar for Modal */
    #modalContent::-webkit-scrollbar {
        width: 8px;
    }

    #modalContent::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    #modalContent::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #3b82f6, #6366f1);
        border-radius: 10px;
    }

    #modalContent::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #2563eb, #4f46e5);
    }

    /* Loading Animation */
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .animate-spin {
        animation: spin 1s linear infinite;
    }
</style>
@endsection
