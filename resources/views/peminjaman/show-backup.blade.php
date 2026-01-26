@extends('layouts.app')

@section('title', 'Detail Peminjaman - ' . $peminjaman->kode_peminjaman)
@section('page-title', 'Detail Peminjaman')
@section('page-subtitle', 'Informasi lengkap transaksi peminjaman')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm">
        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-blue-600 transition-colors font-medium">
            <i class="bi bi-house-door"></i>
            Dashboard
        </a>
        <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
        <a href="{{ route('peminjaman.index') }}" class="text-gray-500 hover:text-blue-600 transition-colors font-medium">
            Data Peminjaman
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
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center shadow-lg">
                            <i class="bi bi-journal-check text-white text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Kode Peminjaman</p>
                            <h1 class="text-3xl font-black text-white">{{ $peminjaman->kode_peminjaman }}</h1>
                        </div>
                    </div>
                    <p class="text-blue-100 text-base">Detail lengkap transaksi peminjaman alat</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    @if($peminjaman->status === 'dikembalikan')
                        <div class="inline-flex items-center gap-2 px-5 py-3 bg-white/20 backdrop-blur-lg rounded-xl border border-white/30 shadow-lg">
                            <i class="bi bi-check-circle-fill text-green-300 text-xl"></i>
                            <div>
                                <p class="text-xs text-green-200 font-medium">Status</p>
                                <p class="text-white font-black">Dikembalikan</p>
                            </div>
                        </div>
                    @elseif($peminjaman->isLate())
                        <div class="inline-flex items-center gap-2 px-5 py-3 bg-white/20 backdrop-blur-lg rounded-xl border border-white/30 shadow-lg animate-pulse">
                            <i class="bi bi-exclamation-circle-fill text-red-300 text-xl"></i>
                            <div>
                                <p class="text-xs text-red-200 font-medium">Status</p>
                                <p class="text-white font-black">Terlambat</p>
                            </div>
                        </div>
                    @else
                        <div class="inline-flex items-center gap-2 px-5 py-3 bg-white/20 backdrop-blur-lg rounded-xl border border-white/30 shadow-lg">
                            <i class="bi bi-clock-fill text-yellow-300 text-xl"></i>
                            <div>
                                <p class="text-xs text-yellow-200 font-medium">Status</p>
                                <p class="text-white font-black">Dipinjam</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Column - Info Cards --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Informasi Tanggal --}}
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="bi bi-calendar-event text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900">Informasi Waktu</h3>
                            <p class="text-sm text-gray-500 font-medium">Timeline peminjaman alat</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-5">
                        {{-- Tanggal Pinjam --}}
                        <div class="flex items-start gap-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-100">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="bi bi-box-arrow-right text-white text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Tanggal Pinjam</p>
                                <p class="text-lg font-black text-gray-900">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
                                <p class="text-sm text-gray-500 font-medium mt-1">{{ $peminjaman->tanggal_pinjam->diffForHumans() }}</p>
                            </div>
                        </div>

                        {{-- Tanggal Kembali Rencana --}}
                        <div class="flex items-start gap-4 p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-2xl border border-orange-100">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="bi bi-calendar-check text-white text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Rencana Kembali</p>
                                <p class="text-lg font-black text-gray-900">{{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}</p>
                                @if($peminjaman->status === 'dipinjam')
                                    @if($peminjaman->isLate())
                                        <div class="inline-flex items-center gap-1 mt-2 px-3 py-1 bg-red-600 text-white text-xs font-bold rounded-lg animate-pulse">
                                            <i class="bi bi-exclamation-triangle-fill"></i>
                                            Terlambat {{ $peminjaman->tanggal_kembali_rencana->diffForHumans() }}
                                        </div>
                                    @else
                                        <p class="text-sm text-orange-600 font-semibold mt-1">
                                            <i class="bi bi-clock"></i>
                                            {{ $peminjaman->tanggal_kembali_rencana->diffForHumans() }}
                                        </p>
                                    @endif
                                @endif
                            </div>
                        </div>

                        {{-- Tanggal Kembali Aktual --}}
                        @if($peminjaman->status === 'dikembalikan' && $peminjaman->tanggal_kembali_aktual)
                            <div class="flex items-start gap-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl border border-green-100">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="bi bi-box-arrow-in-left text-white text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Tanggal Dikembalikan</p>
                                    <p class="text-lg font-black text-gray-900">{{ $peminjaman->tanggal_kembali_aktual->format('d M Y') }}</p>
                                    <p class="text-sm text-green-600 font-semibold mt-1">
                                        <i class="bi bi-check-circle"></i>
                                        {{ $peminjaman->tanggal_kembali_aktual->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Data Peminjam --}}
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-gray-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="bi bi-person-badge text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900">Data Peminjam</h3>
                            <p class="text-sm text-gray-500 font-medium">Informasi lengkap peminjam</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1">
                            <label class="flex items-center gap-2 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-person text-purple-500"></i>
                                Nama Lengkap
                            </label>
                            <p class="text-base font-bold text-gray-900">{{ $peminjaman->nama_lengkap }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="flex items-center gap-2 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-credit-card text-purple-500"></i>
                                NIP
                            </label>
                            <p class="text-base font-bold text-gray-900">{{ $peminjaman->nip }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="flex items-center gap-2 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-building text-purple-500"></i>
                                Departemen
                            </label>
                            <p class="text-base font-bold text-gray-900">{{ $peminjaman->departemen }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="flex items-center gap-2 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-envelope text-purple-500"></i>
                                Email
                            </label>
                            <a href="mailto:{{ $peminjaman->email }}" class="text-base font-bold text-blue-600 hover:text-blue-700 hover:underline">
                                {{ $peminjaman->email }}
                            </a>
                        </div>
                        <div class="space-y-1">
                            <label class="flex items-center gap-2 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-telephone text-purple-500"></i>
                                Telepon
                            </label>
                            <a href="tel:{{ $peminjaman->telepon }}" class="text-base font-bold text-blue-600 hover:text-blue-700 hover:underline">
                                {{ $peminjaman->telepon }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Daftar Alat --}}
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-gray-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="bi bi-box-seam text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-gray-900">Daftar Alat</h3>
                                <p class="text-sm text-gray-500 font-medium">Alat yang dipinjam</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500 font-bold">Total Unit</p>
                            <p class="text-2xl font-black text-indigo-600">{{ $peminjaman->details->sum('jumlah') }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($peminjaman->details as $index => $detail)
                            <div class="group relative bg-gradient-to-r from-gray-50 to-blue-50/30 rounded-2xl p-5 border border-gray-100 hover:shadow-lg hover:border-blue-200 transition-all duration-300">
                                {{-- Number Badge --}}
                                <div class="absolute -left-3 -top-3 w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg text-white font-black">
                                    {{ $index + 1 }}
                                </div>

                                <div class="ml-4">
                                    {{-- Nama & Kode Alat --}}
                                    <div class="mb-4">
                                        <h4 class="text-lg font-black text-gray-900 mb-2">{{ $detail->nama_alat }}</h4>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-lg bg-blue-100 text-blue-700 border border-blue-200">
                                                <i class="bi bi-upc-scan"></i>
                                                {{ $detail->kode_alat }}
                                            </span>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-black rounded-lg bg-gradient-to-r from-orange-400 to-orange-500 text-white shadow-lg">
                                                <i class="bi bi-box"></i>
                                                {{ $detail->jumlah }} Unit
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Kondisi --}}
                                    <div class="space-y-3 pt-4 border-t border-gray-200">
                                        <div class="flex items-center gap-3">
                                            <span class="text-sm font-bold text-gray-600 w-32">Kondisi Pinjam:</span>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-sm font-bold rounded-lg
                                                @if($detail->kondisi_awal === 'baik') bg-green-100 text-green-700
                                                @elseif($detail->kondisi_awal === 'rusak_ringan') bg-yellow-100 text-yellow-700
                                                @elseif($detail->kondisi_awal === 'rusak_berat') bg-red-100 text-red-700
                                                @else bg-gray-100 text-gray-700
                                                @endif">
                                                <i class="bi bi-tools"></i>
                                                {{ \App\Models\Alat::kondisiOptions()[$detail->kondisi_alat] ?? $detail->kondisi_alat }}
                                            </span>
                                        </div>

                                        @if($peminjaman->status === 'dikembalikan' && $detail->kondisi_alat_kembali)
                                            <div class="flex items-center gap-3">
                                                <span class="text-sm font-bold text-gray-600 w-32">Kondisi Kembali:</span>
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-sm font-bold rounded-lg
                                                    @if($detail->kondisi_alat_kembali === 'baik') bg-green-100 text-green-700
                                                    @elseif($detail->kondisi_alat_kembali === 'rusak_ringan') bg-yellow-100 text-yellow-700
                                                    @elseif($detail->kondisi_alat_kembali === 'rusak_berat') bg-red-100 text-red-700
                                                    @else bg-gray-100 text-gray-700
                                                    @endif">
                                                    <i class="bi bi-tools"></i>
                                                    {{ \App\Models\Alat::kondisiOptions()[$detail->kondisi_alat_kembali] ?? $detail->kondisi_alat_kembali }}
                                                </span>
                                            </div>

                                            @if($detail->keterangan)
                                                <div class="mt-3 p-3 bg-blue-50 rounded-xl border border-blue-100">
                                                    <p class="text-xs font-bold text-gray-600 mb-1">
                                                        <i class="bi bi-chat-left-text text-blue-600"></i>
                                                        Keterangan:
                                                    </p>
                                                    <p class="text-sm text-gray-700 italic">{{ $detail->keterangan }}</p>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        {{-- Right Column - Sidebar --}}
        <div class="space-y-6">

            {{-- Keperluan --}}
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-gray-50 to-green-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="bi bi-file-earmark-text text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-gray-900">Keperluan</h3>
                            <p class="text-sm text-gray-500 font-medium">Tujuan peminjaman</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-200">
                        <p class="text-gray-800 whitespace-pre-line leading-relaxed">{{ $peminjaman->keperluan }}</p>
                    </div>
                </div>
            </div>

            {{-- Foto Peminjaman --}}
            @if($peminjaman->foto_peminjaman)
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-6 py-4 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="bi bi-camera text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-gray-900">Foto Pinjam</h3>
                                <p class="text-sm text-gray-500 font-medium">Dokumentasi</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="group relative cursor-pointer rounded-2xl overflow-hidden border-2 border-gray-200 hover:border-blue-500 transition-all duration-300 hover:shadow-xl"
                            onclick="openImageModal('{{ asset($peminjaman->foto_peminjaman) }}', 'Foto Saat Peminjaman')">
                            <img src="{{ asset($peminjaman->foto_peminjaman) }}"
                                alt="Foto Peminjaman"
                                class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500"
                                onerror="this.parentNode.innerHTML='<div class=\'flex items-center justify-center h-48 bg-gray-100\'><i class=\'bi bi-image text-gray-400 text-5xl\'></i></div>'">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-all duration-300 flex items-center justify-center">
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="w-12 h-12 bg-white/90 rounded-full flex items-center justify-center">
                                        <i class="bi bi-zoom-in text-gray-900 text-xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-center text-gray-500 font-medium mt-3">
                            <i class="bi bi-hand-index"></i> Klik untuk memperbesar
                        </p>
                    </div>
                </div>
            @endif

            {{-- Foto Pengembalian --}}
            @if($peminjaman->status === 'dikembalikan' && $peminjaman->foto_pengembalian)
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-gray-50 to-green-50 px-6 py-4 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="bi bi-camera-fill text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-gray-900">Foto Kembali</h3>
                                <p class="text-sm text-gray-500 font-medium">Dokumentasi</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="group relative cursor-pointer rounded-2xl overflow-hidden border-2 border-gray-200 hover:border-green-500 transition-all duration-300 hover:shadow-xl"
                            onclick="openImageModal('{{ asset($peminjaman->foto_pengembalian) }}', 'Foto Saat Pengembalian')">
                            <img src="{{ asset($peminjaman->foto_pengembalian) }}"
                                alt="Foto Pengembalian"
                                class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500"
                                onerror="this.parentNode.innerHTML='<div class=\'flex items-center justify-center h-48 bg-gray-100\'><i class=\'bi bi-image text-gray-400 text-5xl\'></i></div>'">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-all duration-300 flex items-center justify-center">
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="w-12 h-12 bg-white/90 rounded-full flex items-center justify-center">
                                        <i class="bi bi-zoom-in text-gray-900 text-xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-center text-gray-500 font-medium mt-3">
                            <i class="bi bi-hand-index"></i> Klik untuk memperbesar
                        </p>
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('peminjaman.index') }}"
           class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 rounded-xl hover:shadow-lg transition-all font-bold hover:-translate-y-0.5">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Daftar</span>
        </a>

        @if($peminjaman->status === 'dipinjam')
            <a href="{{ route('peminjaman.kembalikan', $peminjaman->id) }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:shadow-lg hover:shadow-green-500/50 transition-all font-bold hover:-translate-y-0.5">
                <i class="bi bi-arrow-return-left"></i>
                <span>Proses Pengembalian</span>
            </a>
        @endif

        {{-- Cetak Detail Peminjaman --}}
        {{-- <button onclick="window.print()"
                class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg hover:shadow-blue-500/50 transition-all font-bold hover:-translate-y-0.5">
            <i class="bi bi-printer"></i>
            <span>Cetak Detail</span>
        </button> --}}
    </div>
</div>

{{-- Premium Image Modal --}}
<div id="imageModal"
     class="hidden fixed inset-0 bg-black/90 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-fadeIn"
     onclick="closeImageModal()">
    <div class="relative max-w-5xl w-full" onclick="event.stopPropagation()">
        {{-- Close Button --}}
        <button onclick="closeImageModal()"
                class="absolute -top-12 right-0 w-10 h-10 bg-white/10 hover:bg-white/20 backdrop-blur-lg rounded-full flex items-center justify-center text-white transition-all hover:scale-110">
            <i class="bi bi-x-lg text-xl"></i>
        </button>

        {{-- Modal Content --}}
        <div class="bg-white rounded-3xl overflow-hidden shadow-2xl">
            {{-- Modal Header --}}
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <h3 id="modalImageTitle" class="text-xl font-black text-white"></h3>
            </div>

            {{-- Image Container with Max Height --}}
            <div class="relative bg-gray-900 flex items-center justify-center" style="max-height: 75vh;">
                <img id="modalImage"
                     src=""
                     alt=""
                     class="max-w-full max-h-[75vh] w-auto h-auto object-contain">
            </div>

            {{-- Modal Footer --}}
            <div class="bg-gray-50 px-6 py-4 flex items-center justify-between">
                <p class="text-sm text-gray-600 font-medium">
                    <i class="bi bi-info-circle text-blue-600"></i>
                    Gunakan scroll untuk zoom, ESC untuk menutup
                </p>
                <button onclick="closeImageModal()"
                        class="px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-lg hover:shadow-lg transition-all font-semibold">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openImageModal(imageSrc, title) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modalImageTitle');

        modalImage.src = imageSrc;
        modalTitle.textContent = title;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal dengan ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });

    // Prevent click propagation on image
    document.getElementById('modalImage')?.addEventListener('click', function(e) {
        e.stopPropagation();
    });
</script>

<style>
    /* Animations */
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

    /* Print Styles */
    @media print {
        body * {
            visibility: hidden;
        }

        .space-y-6, .space-y-6 * {
            visibility: visible;
        }

        .space-y-6 {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        /* Hide buttons and interactive elements */
        button,
        nav,
        .hover\:shadow-lg,
        [onclick] {
            display: none !important;
        }

        /* Adjust colors for print */
        .bg-gradient-to-br,
        .bg-gradient-to-r {
            background: white !important;
            border: 1px solid #e5e7eb !important;
        }
    }
</style>
@endsection
