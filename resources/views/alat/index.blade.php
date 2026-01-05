@extends('layouts.app')

@section('title', 'Data Alat')
@section('page-title', 'Data Alat')
@section('page-subtitle', 'Kelola inventaris dan ketersediaan alat')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm">
        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-blue-600 transition-colors font-medium">
            <i class="bi bi-house-door"></i>
            Dashboard
        </a>
        <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
        <span class="text-gray-900 font-semibold">Data Alat</span>
    </nav>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total Alat --}}
        <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/5 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="bi bi-box-seam text-white text-xl"></i>
                    </div>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total</span>
                </div>
                <p class="text-3xl font-black text-gray-900 mb-1">{{ \App\Models\Alat::sum('jumlah_total') }}</p>
                <p class="text-sm text-gray-500 font-medium">{{ \App\Models\Alat::count() }} Jenis Alat</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
        </div>

        {{-- Tersedia --}}
        <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="absolute top-0 right-0 w-24 h-24 bg-green-500/5 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="bi bi-check-circle-fill text-white text-xl"></i>
                    </div>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Tersedia</span>
                </div>
                <p class="text-3xl font-black text-gray-900 mb-1">{{ \App\Models\Alat::sum('jumlah_tersedia') }}</p>
                <p class="text-sm text-gray-500 font-medium">Siap Dipinjam</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-green-500 to-emerald-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
        </div>

        {{-- Dipinjam --}}
        <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="absolute top-0 right-0 w-24 h-24 bg-yellow-500/5 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="bi bi-hourglass-split text-white text-xl"></i>
                    </div>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Dipinjam</span>
                </div>
                <p class="text-3xl font-black text-gray-900 mb-1">
                    {{ \App\Models\Alat::sum('jumlah_total') - \App\Models\Alat::sum('jumlah_tersedia') }}
                </p>
                <p class="text-sm text-gray-500 font-medium">Sedang Digunakan</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-yellow-500 to-orange-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
        </div>

        {{-- Perlu Perhatian --}}
        <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="absolute top-0 right-0 w-24 h-24 bg-red-500/5 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="bi bi-exclamation-triangle text-white text-xl"></i>
                    </div>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Perhatian</span>
                </div>
                <p class="text-3xl font-black text-gray-900 mb-1">
                    {{ \App\Models\Alat::whereIn('kondisi', ['rusak_ringan', 'rusak_berat', 'maintenance'])->count() }}
                </p>
                <p class="text-sm text-gray-500 font-medium">Rusak/Maintenance</p>
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
                        <h2 class="text-2xl font-black text-gray-900">Daftar Alat</h2>
                    </div>
                    <p class="text-sm text-gray-500 font-medium ml-6">Kelola dan monitor ketersediaan alat</p>
                </div>

                {{-- Tombol Import --}}
                <a href="{{ route('alat.import.form') }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:shadow-lg hover:shadow-green-500/50 transition-all text-sm font-bold">
                    <i class="bi bi-cloud-upload text-lg"></i>
                    <span>Import Excel</span>
                </a>

                {{-- Tombol Create --}}
                <a href="{{ route('alat.create') }}"
                   class="group inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg hover:shadow-blue-500/50 transition-all text-sm font-bold hover:-translate-y-0.5">
                    <i class="bi bi-plus-circle text-lg"></i>
                    <span>Tambah Alat</span>
                    <i class="bi bi-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        {{-- Filter & Search Section --}}
        <div class="px-6 py-5 bg-gradient-to-r from-gray-50 to-purple-50 border-b border-gray-100">
            <form method="GET" action="{{ route('alat.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Search --}}
                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama, kode alat..."
                            class="w-full pl-11 pr-4 py-2.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium transition-all hover:border-gray-300"
                        >
                        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
                    </div>

                    {{-- Kondisi Filter --}}
                    <select
                        name="kondisi"
                        class="px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium transition-all hover:border-gray-300"
                    >
                        <option value="">Semua Kondisi</option>
                        @foreach(\App\Models\Alat::kondisiOptions() as $key => $label)
                            <option value="{{ $key }}" {{ request('kondisi') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Kategori Filter --}}
                    <select
                        name="kategori"
                        class="px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium transition-all hover:border-gray-300"
                    >
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                                {{ $kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-3 mt-4">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-blue-500/50 transition-all">
                        <i class="bi bi-funnel"></i> Terapkan Filter
                    </button>
                    @if(request()->anyFilled(['search', 'kondisi', 'kategori']))
                        <a href="{{ route('alat.index') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-200 text-gray-700 rounded-xl font-bold text-sm hover:bg-gray-300 transition-colors">
                            <i class="bi bi-arrow-repeat"></i> Reset Filter
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            @if($alats->isEmpty())
                <div class="text-center py-20">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl mb-6 shadow-inner">
                        <i class="bi bi-box-seam text-5xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">
                        @if(request()->anyFilled(['search', 'kondisi', 'kategori']))
                            Tidak Ada Hasil Ditemukan
                        @else
                            Belum Ada Data Alat
                        @endif
                    </h3>
                    <p class="text-gray-500 mb-6 max-w-md mx-auto">
                        @if(request()->anyFilled(['search', 'kondisi', 'kategori']))
                            Tidak ditemukan alat yang sesuai dengan filter. Silakan coba reset filter atau gunakan kata kunci lain.
                        @else
                            Mulai dengan menambahkan alat pertama untuk mengelola inventaris Anda dengan lebih baik.
                        @endif
                    </p>
                    @if(!request()->anyFilled(['search', 'kondisi', 'kategori']))
                        <a href="{{ route('alat.create') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg hover:shadow-blue-500/50 transition-all font-semibold">
                            <i class="bi bi-plus-circle text-lg"></i>
                            <span>Tambah Alat Pertama</span>
                        </a>
                    @else
                        <a href="{{ route('alat.index') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors font-semibold">
                            <i class="bi bi-arrow-repeat"></i>
                            <span>Reset Filter</span>
                        </a>
                    @endif
                </div>
            @else
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">
                                Informasi Alat
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-black text-gray-600 uppercase tracking-wider">
                                Stok
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">
                                Kondisi
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">
                                Lokasi
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-black text-gray-600 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-50">
                        @foreach($alats as $alat)
                        <tr class="group hover:bg-gradient-to-r hover:from-blue-50/30 hover:to-indigo-50/30 transition-all duration-300">
                            {{-- Informasi Alat --}}
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                                            <i class="bi bi-box-seam text-xl"></i>
                                        </div>
                                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="font-bold text-gray-900 truncate text-base">{{ $alat->nama_alat }}</p>
                                        <div class="flex items-center gap-2 mt-1 flex-wrap">
                                            <code class="inline-flex items-center gap-1 text-xs font-mono font-bold bg-gray-100 px-2.5 py-1 rounded-lg text-gray-700 group-hover:bg-blue-100 group-hover:text-blue-700 transition-colors">
                                                <i class="bi bi-upc-scan"></i>
                                                {{ $alat->kode_alat }}
                                            </code>
                                            @if($alat->kategori)
                                                <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 bg-purple-100 text-purple-700 rounded-lg">
                                                    <i class="bi bi-tag-fill"></i>
                                                    {{ $alat->kategori }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Stok --}}
                            <td class="px-6 py-5">
                                <div class="flex flex-col items-center gap-3">
                                    {{-- Total --}}
                                    <div class="text-center">
                                        <p class="text-xs font-bold text-gray-500 mb-1.5">TOTAL</p>
                                        <div class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-xl font-black text-xl shadow-lg">
                                            {{ $alat->jumlah_total }}
                                        </div>
                                    </div>

                                    {{-- Divider --}}
                                    <div class="w-full h-px bg-gray-200"></div>

                                    {{-- Tersedia --}}
                                    <div class="text-center">
                                        <p class="text-xs font-bold text-gray-500 mb-1.5">TERSEDIA</p>
                                        @if($alat->jumlah_tersedia > 0)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-sm font-black bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg shadow-green-500/30">
                                                <i class="bi bi-check-circle-fill"></i>
                                                {{ $alat->jumlah_tersedia }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-sm font-black bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg shadow-red-500/30 animate-pulse">
                                                <i class="bi bi-x-circle-fill"></i>
                                                Habis
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Kondisi --}}
                            <td class="px-6 py-5">
                                @php
                                    $kondisiBadge = [
                                        'baik' => [
                                            'gradient' => 'from-green-500 to-emerald-500',
                                            'shadow' => 'shadow-green-500/30',
                                            'icon' => 'bi-check-circle-fill'
                                        ],
                                        'rusak_ringan' => [
                                            'gradient' => 'from-yellow-400 to-orange-400',
                                            'shadow' => 'shadow-yellow-500/30',
                                            'icon' => 'bi-exclamation-circle-fill'
                                        ],
                                        'rusak_berat' => [
                                            'gradient' => 'from-red-500 to-pink-500',
                                            'shadow' => 'shadow-red-500/30',
                                            'icon' => 'bi-x-circle-fill'
                                        ],
                                        'maintenance' => [
                                            'gradient' => 'from-blue-500 to-indigo-500',
                                            'shadow' => 'shadow-blue-500/30',
                                            'icon' => 'bi-tools'
                                        ],
                                    ];
                                    $badge = $kondisiBadge[$alat->kondisi] ?? [
                                        'gradient' => 'from-gray-500 to-gray-600',
                                        'shadow' => 'shadow-gray-500/30',
                                        'icon' => 'bi-question-circle'
                                    ];
                                @endphp
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-black bg-gradient-to-r {{ $badge['gradient'] }} text-white shadow-lg {{ $badge['shadow'] }}">
                                    <i class="bi {{ $badge['icon'] }}"></i>
                                    {{ \App\Models\Alat::kondisiOptions()[$alat->kondisi] ?? 'Unknown' }}
                                </span>
                            </td>

                            {{-- Lokasi --}}
                            <td class="px-6 py-5">
                                @if($alat->lokasi)
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="bi bi-geo-alt-fill text-purple-600 text-sm"></i>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700">{{ $alat->lokasi }}</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2 text-gray-400">
                                        <i class="bi bi-geo-alt text-lg"></i>
                                        <span class="text-sm italic">Tidak ditentukan</span>
                                    </div>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-5">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('alat.show', $alat) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-bold text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-all hover:shadow-md"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                        <span class="hidden xl:inline">Detail</span>
                                    </a>

                                    <a href="{{ route('alat.edit', $alat) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-bold text-yellow-600 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-all hover:shadow-md"
                                       title="Edit Alat">
                                        <i class="bi bi-pencil"></i>
                                        <span class="hidden xl:inline">Edit</span>
                                    </a>

                                    <form action="{{ route('alat.destroy', $alat) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus alat {{ $alat->nama_alat }}?\n\nAksi ini tidak dapat dibatalkan!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-bold text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-all hover:shadow-md"
                                                title="Hapus Alat">
                                            <i class="bi bi-trash"></i>
                                            <span class="hidden xl:inline">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        {{-- Pagination --}}
        @if($alats->hasPages())
            <div class="px-6 py-5 border-t border-gray-100 bg-gray-50/50">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-600 font-medium">
                        Menampilkan
                        <span class="font-black text-gray-900">{{ $alats->firstItem() }}</span>
                        sampai
                        <span class="font-black text-gray-900">{{ $alats->lastItem() }}</span>
                        dari
                        <span class="font-black text-gray-900">{{ $alats->total() }}</span>
                        alat
                    </div>
                    <div>
                        {{ $alats->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Quick Stats Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Tingkat Ketersediaan --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 rounded-2xl p-6 shadow-xl">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>

            <div class="relative">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                        <i class="bi bi-info-circle-fill text-white text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-blue-100 mb-1">TINGKAT KETERSEDIAAN</p>
                        <p class="text-white font-medium text-sm leading-relaxed">
                            @php
                                $total = \App\Models\Alat::sum('jumlah_total');
                                $tersedia = \App\Models\Alat::sum('jumlah_tersedia');
                                $percentage = $total > 0 ? round(($tersedia / $total) * 100, 1) : 0;
                            @endphp
                            Alat tersedia untuk dipinjam
                        </p>
                    </div>
                </div>
                <div class="text-5xl font-black text-white">{{ $percentage }}%</div>
            </div>
        </div>

        {{-- Kondisi Baik --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-green-600 via-emerald-600 to-teal-600 rounded-2xl p-6 shadow-xl">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>

            <div class="relative">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                        <i class="bi bi-check-circle-fill text-white text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-green-100 mb-1">KONDISI BAIK</p>
                        <p class="text-white font-medium text-sm leading-relaxed">
                            Jenis alat dalam kondisi baik
                        </p>
                    </div>
                </div>
                <div class="text-5xl font-black text-white">{{ \App\Models\Alat::where('kondisi', 'baik')->count() }}</div>
            </div>
        </div>

        {{-- Total Kategori --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-purple-600 via-pink-600 to-rose-600 rounded-2xl p-6 shadow-xl">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>

            <div class="relative">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                        <i class="bi bi-grid-3x3-gap-fill text-white text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-purple-100 mb-1">TOTAL KATEGORI</p>
                        <p class="text-white font-medium text-sm leading-relaxed">
                            Kategori alat terdaftar
                        </p>
                    </div>
                </div>
                <div class="text-5xl font-black text-white">{{ \App\Models\Alat::distinct('kategori')->count('kategori') }}</div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Auto submit form on filter change
    document.querySelectorAll('select[name="kondisi"], select[name="kategori"]').forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
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

    document.querySelectorAll('tbody tr').forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        row.style.transition = `all 0.5s ease ${index * 0.05}s`;
        observer.observe(row);
    });
</script>
@endpush
