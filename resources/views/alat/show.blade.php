@extends('layouts.app')

@section('title', 'Detail Alat - ' . ($alat->kode_alat ?: $alat->nama_alat))
@section('page-title', 'Detail Alat')
@section('page-subtitle', 'Informasi lengkap dan riwayat peminjaman')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm">
        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-blue-600 transition-colors font-medium">
            <i class="bi bi-house-door"></i>
            Dashboard
        </a>
        <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
        <a href="{{ route('alat.index') }}" class="text-gray-500 hover:text-blue-600 transition-colors font-medium">
            Data Alat
        </a>
        <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
        <span class="text-gray-900 font-semibold">Detail</span>
    </nav>

    {{-- Header Card --}}
    <div class="bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 rounded-3xl shadow-2xl overflow-hidden">
        <div class="relative p-8">
            {{-- Animated Background --}}
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 -left-4 w-72 h-72 bg-white rounded-full mix-blend-overlay filter blur-xl animate-blob"></div>
                <div class="absolute top-0 -right-4 w-72 h-72 bg-white rounded-full mix-blend-overlay filter blur-xl animate-blob animation-delay-2000"></div>
            </div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-20 h-20 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center shadow-xl">
                        <i class="bi bi-box-seam text-white text-4xl"></i>
                    </div>
                    <div>
                        <p class="text-blue-100 text-sm font-medium mb-1">Kode Alat</p>
                        <h1 class="text-4xl font-black text-white mb-2">{{ $alat->kode_alat ?? '—' }}</h1>
                        <p class="text-xl text-blue-100 font-semibold">{{ $alat->nama_alat }}</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('alat.index') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-white/20 backdrop-blur-lg text-white rounded-xl hover:bg-white/30 transition-all font-bold border border-white/30 shadow-lg">
                        <i class="bi bi-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                    <a href="{{ route('alat.edit', $alat) }}"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl hover:shadow-lg hover:shadow-amber-500/50 transition-all font-bold">
                        <i class="bi bi-pencil-square"></i>
                        <span>Edit Alat</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Column - Main Content --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Info Card --}}
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="bi bi-info-circle text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900">Informasi Alat</h3>
                            <p class="text-sm text-gray-500 font-medium">Detail lengkap alat</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <dt class="flex items-center gap-2 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-upc-scan text-blue-500"></i>
                                Kode Alat
                            </dt>
                            <dd class="text-lg font-mono font-black bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-3 rounded-xl text-gray-900 border border-blue-200">
                                {{ $alat->kode_alat ?? '—' }}
                            </dd>
                        </div>

                        <div class="space-y-2">
                            <dt class="flex items-center gap-2 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-box-seam text-blue-500"></i>
                                Nama Alat
                            </dt>
                            <dd class="text-lg font-bold text-gray-900 py-3">
                                {{ $alat->nama_alat }}
                            </dd>
                        </div>

                        <div class="space-y-2">
                            <dt class="flex items-center gap-2 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-tag text-purple-500"></i>
                                Kategori
                            </dt>
                            <dd>
                                @if($alat->kategori)
                                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 border border-purple-200">
                                        <i class="bi bi-tag-fill"></i>
                                        {{ $alat->kategori }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </dd>
                        </div>

                        <div class="space-y-2">
                            <dt class="flex items-center gap-2 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-geo-alt text-purple-500"></i>
                                Lokasi
                            </dt>
                            <dd class="flex items-center gap-2 text-gray-900 font-semibold">
                                <i class="bi bi-geo-alt-fill text-purple-400"></i>
                                <span>{{ $alat->lokasi ?? '-' }}</span>
                            </dd>
                        </div>

                        <div class="space-y-2">
                            <dt class="flex items-center gap-2 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-tools text-green-500"></i>
                                Kondisi
                            </dt>
                            <dd>
                                @php
                                    $kondisiBadge = [
                                        'baik' => ['bg' => 'from-green-500 to-emerald-600', 'icon' => 'bi-check-circle-fill'],
                                        'rusak_ringan' => ['bg' => 'from-yellow-500 to-orange-500', 'icon' => 'bi-exclamation-circle-fill'],
                                        'rusak_berat' => ['bg' => 'from-red-500 to-pink-500', 'icon' => 'bi-x-circle-fill'],
                                        'maintenance' => ['bg' => 'from-blue-500 to-indigo-600', 'icon' => 'bi-tools'],
                                    ];
                                    $badge = $kondisiBadge[$alat->kondisi] ?? ['bg' => 'from-gray-500 to-gray-600', 'icon' => 'bi-question-circle'];
                                @endphp
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-black bg-gradient-to-r {{ $badge['bg'] }} text-white shadow-lg">
                                    <i class="bi {{ $badge['icon'] }}"></i>
                                    {{ \App\Models\Alat::kondisiOptions()[$alat->kondisi] }}
                                </span>
                            </dd>
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <dt class="flex items-center gap-2 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-file-text text-blue-500"></i>
                                Deskripsi
                            </dt>
                            <dd class="text-gray-700 bg-gray-50 p-4 rounded-xl border border-gray-200 leading-relaxed">
                                {{ $alat->deskripsi ?? 'Tidak ada deskripsi' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Spesifikasi Tambahan --}}
            @php
                $hasSpesifikasi = $alat->spesifikasi_type || $alat->merk || $alat->kapasitas ||
                                 $alat->jenis_tools || $alat->kategori_tools || $alat->proyek ||
                                 $alat->pic || $alat->pemakai || $alat->lokasi_distribusi ||
                                 $alat->sticker !== null || $alat->hilang === true;
            @endphp

            @if($hasSpesifikasi)
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-cyan-50 to-teal-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-cyan-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="bi bi-sliders text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900">Spesifikasi & Penugasan</h3>
                            <p class="text-sm text-gray-500 font-medium">Detail teknis dan informasi penugasan</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($alat->spesifikasi_type)
                        <div class="space-y-2">
                            <dt class="flex items-center gap-2 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-gear-wide-connected text-cyan-500"></i>
                                Tipe Spesifikasi
                            </dt>
                            <dd class="text-gray-900 bg-cyan-50 p-3 rounded-xl border border-cyan-200 font-mono">
                                {{ $alat->spesifikasi_type }}
                            </dd>
                        </div>
                        @endif

                        @if($alat->merk)
                        <div class="space-y-2">
                            <dt class="flex items-center gap-2 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-badge-tm text-cyan-500"></i>
                                Merk
                            </dt>
                            <dd class="text-lg font-bold text-gray-900 py-3">
                                {{ $alat->merk }}
                            </dd>
                        </div>
                        @endif

                        @if($alat->kapasitas)
                        <div class="space-y-2">
                            <dt class="flex items-center gap-2 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-droplet text-cyan-500"></i>
                                Kapasitas
                            </dt>
                            <dd class="text-gray-900 bg-cyan-50 p-3 rounded-xl border border-cyan-200">
                                {{ $alat->kapasitas }}
                            </dd>
                        </div>
                        @endif

                        @if($alat->jenis_tools)
                        <div class="space-y-2">
                            <dt class="flex items-center gap-2 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-wrench text-amber-500"></i>
                                Jenis Tools
                            </dt>
                            <dd>
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-amber-100 to-orange-100 text-amber-700 border border-amber-200">
                                    {{ $alat->jenis_tools }}
                                </span>
                            </dd>
                        </div>
                        @endif

                        @if($alat->kategori_tools)
                        <div class="space-y-2">
                            <dt class="flex items-center gap-2 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-layers text-amber-500"></i>
                                Kategori Tools
                            </dt>
                            <dd>
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 border border-purple-200">
                                    {{ $alat->kategori_tools }}
                                </span>
                            </dd>
                        </div>
                        @endif

                        @if($alat->proyek)
                        <div class="space-y-2">
                            <dt class="flex items-center gap-2 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-building text-amber-500"></i>
                                Proyek
                            </dt>
                            <dd>
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 border border-blue-200">
                                    {{ $alat->proyek }}
                                </span>
                            </dd>
                        </div>
                        @endif

                        @if($alat->pic)
                        <div class="space-y-2">
                            <dt class="flex items-center gap-2 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-person-circle text-amber-500"></i>
                                PIC
                            </dt>
                            <dd class="text-gray-900 font-semibold">
                                {{ $alat->pic }}
                            </dd>
                        </div>
                        @endif

                        @if($alat->pemakai)
                        <div class="space-y-2">
                            <dt class="flex items-center gap-2 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-person text-amber-500"></i>
                                Pemakai
                            </dt>
                            <dd class="text-gray-900 font-semibold">
                                {{ $alat->pemakai }}
                            </dd>
                        </div>
                        @endif

                        @if($alat->lokasi_distribusi)
                        <div class="space-y-2">
                            <dt class="flex items-center gap-2 text-sm font-bold text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-geo-alt text-amber-500"></i>
                                Lokasi Distribusi
                            </dt>
                            <dd class="flex items-center gap-2 text-gray-900 font-semibold">
                                <i class="bi bi-geo-alt-fill text-amber-400"></i>
                                {{ $alat->lokasi_distribusi }}
                            </dd>
                        </div>
                        @endif
                    </dl>

                    {{-- Status Boolean --}}
                    <div class="mt-6 flex flex-wrap gap-4">
                        {{-- Sticker --}}
                        <div class="flex items-center gap-2">
                            <i class="bi {{ $alat->sticker ? 'bi-tag-fill text-green-500' : 'bi-tag text-gray-400' }} text-xl"></i>
                            <span class="text-sm font-bold {{ $alat->sticker ? 'text-green-700' : 'text-gray-500' }}">
                                {{ $alat->sticker ? 'Memiliki Sticker' : 'Tidak Ada Sticker' }}
                            </span>
                        </div>

                        {{-- Hilang --}}
                        @if($alat->hilang)
                        <div class="flex items-center gap-2">
                            <i class="bi bi-exclamation-triangle-fill text-red-500 text-xl"></i>
                            <span class="text-sm font-bold text-red-700">Dilaporkan Hilang</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- Stock Card --}}
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-gray-50 to-green-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="bi bi-boxes text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900">Informasi Stok</h3>
                            <p class="text-sm text-gray-500 font-medium">Status ketersediaan alat</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="group relative bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-5 text-center shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
                            <div class="absolute inset-0 bg-white/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="relative">
                                <p class="text-sm font-bold text-blue-100 mb-2">Total</p>
                                <p class="text-4xl font-black text-white mb-1">{{ $alat->jumlah_total }}</p>
                                <p class="text-xs text-blue-100 font-medium">Unit</p>
                            </div>
                        </div>

                        <div class="group relative bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-5 text-center shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
                            <div class="absolute inset-0 bg-white/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="relative">
                                <p class="text-sm font-bold text-green-100 mb-2">Tersedia</p>
                                <p class="text-4xl font-black text-white mb-1">{{ $alat->jumlah_tersedia }}</p>
                                <p class="text-xs text-green-100 font-medium">Unit</p>
                            </div>
                        </div>

                        <div class="group relative bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl p-5 text-center shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
                            <div class="absolute inset-0 bg-white/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="relative">
                                <p class="text-sm font-bold text-orange-100 mb-2">Dipinjam</p>
                                <p class="text-4xl font-black text-white mb-1">{{ $alat->jumlah_total - $alat->jumlah_tersedia }}</p>
                                <p class="text-xs text-orange-100 font-medium">Unit</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Transaction History --}}
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-gray-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="bi bi-clock-history text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-gray-900">Riwayat Peminjaman</h3>
                                <p class="text-sm text-gray-500 font-medium">10 Transaksi terakhir</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    @if($alat->peminjamanDetails && $alat->peminjamanDetails->isNotEmpty())
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-100">
                                    <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">Kode</th>
                                    <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">Peminjam</th>
                                    <th class="px-6 py-4 text-center text-xs font-black text-gray-600 uppercase tracking-wider">Qty</th>
                                    <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">Kondisi</th>
                                    <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-4 text-center text-xs font-black text-gray-600 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-50">
                                @foreach($alat->peminjamanDetails->take(10) as $detail)
                                    <tr class="group hover:bg-gradient-to-r hover:from-blue-50/30 hover:to-indigo-50/30 transition-all duration-300">
                                        <td class="px-6 py-4">
                                            <a href="{{ route('peminjaman.show', $detail->peminjaman->id) }}"
                                               class="inline-flex items-center gap-2 font-mono text-sm font-bold text-blue-600 hover:text-blue-800 hover:underline">
                                                <i class="bi bi-link-45deg"></i>
                                                {{ $detail->peminjaman->kode_peminjaman }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="relative">
                                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center text-white font-black text-sm shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                        {{ strtoupper(substr($detail->peminjaman->peminjam->nama_lengkap ?? $detail->peminjaman->nama_lengkap, 0, 1)) }}
                                                    </div>
                                                    <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white"></div>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-bold text-gray-900 text-sm truncate">
                                                        {{ $detail->peminjaman->peminjam->nama_lengkap ?? $detail->peminjaman->nama_lengkap }}
                                                    </p>
                                                    <p class="text-xs text-gray-500 truncate flex items-center gap-1">
                                                        <i class="bi bi-building"></i>
                                                        {{ $detail->peminjaman->peminjam->departemen ?? $detail->peminjaman->departemen }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center justify-center w-10 h-10 bg-gradient-to-br from-blue-100 to-indigo-100 text-blue-700 rounded-xl font-black text-sm shadow-sm">
                                                {{ $detail->jumlah }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="space-y-2">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-xs text-gray-500 font-bold w-16">Pinjam:</span>
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-100 text-blue-700">
                                                        {{ \App\Models\Peminjaman::kondisiOptions()[$detail->kondisi_alat] ?? '-' }}
                                                    </span>
                                                </div>

                                                @if($detail->kondisi_alat_kembali)
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-xs text-gray-500 font-bold w-16">Kembali:</span>
                                                        @php
                                                            $kondisiKembaliBadge = [
                                                                'baik' => ['bg' => 'bg-green-100', 'text' => 'text-green-700'],
                                                                'rusak_ringan' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
                                                                'rusak_berat' => ['bg' => 'bg-red-100', 'text' => 'text-red-700'],
                                                                'maintenance' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700'],
                                                            ];
                                                            $badgeKembali = $kondisiKembaliBadge[$detail->kondisi_alat_kembali] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700'];
                                                        @endphp
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold {{ $badgeKembali['bg'] }} {{ $badgeKembali['text'] }}">
                                                            {{ \App\Models\Peminjaman::kondisiOptions()[$detail->kondisi_alat_kembali] ?? '-' }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div>
                                                <p class="text-sm font-bold text-gray-900">
                                                    {{ $detail->peminjaman->tanggal_pinjam->format('d M Y') }}
                                                </p>
                                                <p class="text-xs text-gray-500 font-medium">
                                                    {{ $detail->peminjaman->tanggal_pinjam->diffForHumans() }}
                                                </p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($detail->peminjaman->status === 'dikembalikan')
                                                <span class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-black bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    Dikembalikan
                                                </span>
                                            @elseif($detail->peminjaman->isLate())
                                                <span class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-black bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg animate-pulse">
                                                    <i class="bi bi-exclamation-circle-fill"></i>
                                                    Terlambat
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-black bg-gradient-to-r from-yellow-400 to-orange-400 text-white shadow-lg">
                                                    <i class="bi bi-clock-fill"></i>
                                                    Dipinjam
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-16">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl mb-4 shadow-inner">
                                <i class="bi bi-inbox text-4xl text-gray-400"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-700 mb-2">Belum Ada Riwayat</h4>
                            <p class="text-sm text-gray-500">Alat ini belum pernah dipinjam</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Column - Sidebar --}}
        <div class="space-y-6">

            {{-- Statistics Card --}}
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="bi bi-bar-chart-fill text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-gray-900">Statistik</h3>
                            <p class="text-sm text-gray-500 font-medium">Ringkasan peminjaman</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-5">
                    {{-- Total Peminjaman --}}
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-bold text-gray-700">Total Peminjaman</span>
                            <span class="text-2xl font-black text-blue-600">{{ $totalPeminjaman }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full shadow-inner" style="width: 100%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2 font-medium">Semua transaksi</p>
                    </div>

                    {{-- Sedang Dipinjam --}}
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-bold text-gray-700">Sedang Dipinjam</span>
                            <span class="text-2xl font-black text-orange-600">{{ $sedangDipinjam }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 h-3 rounded-full transition-all duration-500 shadow-inner"
                                 style="width: {{ $totalPeminjaman ? ($sedangDipinjam / $totalPeminjaman * 100) : 0 }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2 font-medium">
                            {{ $totalPeminjaman ? number_format(($sedangDipinjam / $totalPeminjaman * 100), 1) : 0 }}% dari total
                        </p>
                    </div>

                    {{-- Dikembalikan --}}
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-bold text-gray-700">Dikembalikan</span>
                            <span class="text-2xl font-black text-green-600">{{ $sudahDikembalikan }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-3 rounded-full transition-all duration-500 shadow-inner"
                                 style="width: {{ $totalPeminjaman ? ($sudahDikembalikan / $totalPeminjaman * 100) : 0 }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2 font-medium">
                            {{ $totalPeminjaman ? number_format(($sudahDikembalikan / $totalPeminjaman * 100), 1) : 0 }}% dari total
                        </p>
                    </div>

                    @isset($totalUnitDipinjam)
                    <div class="pt-5 border-t-2 border-gray-100">
                        <div class="p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-2xl border border-orange-200">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-bold text-gray-700">Total Unit Dipinjam</span>
                                <span class="text-3xl font-black text-orange-600">{{ $totalUnitDipinjam }}</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-2 font-medium flex items-center gap-1">
                                <i class="bi bi-box text-orange-500"></i>
                                Unit sedang dipinjam saat ini
                            </p>
                        </div>
                    </div>
                    @endisset
                </div>
            </div>

            {{-- Additional Info --}}
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-gray-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="bi bi-info-circle-fill text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-gray-900">Info Tambahan</h3>
                            <p class="text-sm text-gray-500 font-medium">Data sistem</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    <div class="flex items-start gap-3 p-3 bg-blue-50 rounded-xl border border-blue-100">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                            <i class="bi bi-calendar-plus text-white"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold mb-1">Ditambahkan</p>
                            <p class="font-black text-gray-900">{{ $alat->created_at->isoFormat('D MMM Y') }}</p>
                            <p class="text-xs text-gray-500 font-medium mt-0.5">{{ $alat->created_at->format('H:i') }} WIB</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-3 bg-purple-50 rounded-xl border border-purple-100">
                        <div class="flex-shrink-0 w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                            <i class="bi bi-calendar-event text-white"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold mb-1">Terakhir Diupdate</p>
                            <p class="font-black text-gray-900">{{ $alat->updated_at->isoFormat('D MMM Y') }}</p>
                            <p class="text-xs text-gray-500 font-medium mt-0.5">{{ $alat->updated_at->format('H:i') }} WIB</p>
                        </div>
                    </div>

                    {{-- Alerts --}}
                    @if($alat->jumlah_tersedia == 0)
                        <div class="p-4 bg-gradient-to-r from-red-50 to-pink-50 border-2 border-red-200 rounded-2xl">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center">
                                    <i class="bi bi-exclamation-triangle-fill text-white"></i>
                                </div>
                                <div>
                                    <p class="font-black text-red-900">Stok Habis!</p>
                                    <p class="text-xs text-red-700 mt-1 font-medium">Semua unit sedang dipinjam</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($alat->kondisi !== 'baik')
                        <div class="p-4 bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-200 rounded-2xl">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                                    <i class="bi bi-tools text-white"></i>
                                </div>
                                <div>
                                    <p class="font-black text-yellow-900">Perlu Perhatian!</p>
                                    <p class="text-xs text-yellow-700 mt-1 font-medium">
                                        Kondisi: {{ \App\Models\Alat::kondisiOptions()[$alat->kondisi] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Foto Tools (jika Anda mengaktifkan) --}}
                    {{-- @if($alat->foto_tools)
                    <div class="flex items-start gap-3 p-3 bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl border border-blue-100">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                            <i class="bi bi-camera text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500 font-bold mb-1">Foto Alat</p>
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $alat->foto_tools) }}"
                                     alt="Foto {{ $alat->nama_alat }}"
                                     class="w-full max-w-xs rounded-lg shadow-md border border-gray-200">
                            </div>
                        </div>
                    </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes blob {
        0%, 100% {
            transform: translate(0, 0) scale(1);
        }
        25% {
            transform: translate(20px, -50px) scale(1.1);
        }
        50% {
            transform: translate(-20px, 20px) scale(0.9);
        }
        75% {
            transform: translate(50px, 50px) scale(1.05);
        }
    }

    .animate-blob {
        animation: blob 7s infinite;
    }

    .animation-delay-2000 {
        animation-delay: 2s;
    }
</style>
@endsection
