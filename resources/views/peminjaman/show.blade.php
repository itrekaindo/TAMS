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
                    <div
                        class="absolute top-0 -left-4 w-72 h-72 bg-white rounded-full mix-blend-overlay filter blur-xl animate-blob">
                    </div>
                    <div
                        class="absolute top-0 -right-4 w-72 h-72 bg-white rounded-full mix-blend-overlay filter blur-xl animate-blob animation-delay-2000">
                    </div>
                </div>

                <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <div
                                class="w-12 h-12 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center shadow-lg">
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
                        @php
                            // Hitung total alat dan alat yang sudah dikembalikan
                            $totalAlat = $peminjaman->details->count();
                            $alatKembali = $peminjaman->details
                                ->filter(function ($detail) {
                                    return $detail->kondisi_alat_kembali !== null;
                                })
                                ->count();
                        @endphp

                        @if ($peminjaman->status === 'dikembalikan')
                            <div
                                class="inline-flex items-center gap-2 px-5 py-3 bg-white/20 backdrop-blur-lg rounded-xl border border-white/30 shadow-lg">
                                <i class="bi bi-check-circle-fill text-green-300 text-xl"></i>
                                <div>
                                    <p class="text-xs text-green-200 font-medium">Status</p>
                                    <p class="text-white font-black">Dikembalikan</p>
                                </div>
                            </div>
                        @elseif($peminjaman->status === 'sebagian_dikembalikan')
                            <div
                                class="inline-flex items-center gap-2 px-5 py-3 bg-white/20 backdrop-blur-lg rounded-xl border border-white/30 shadow-lg">
                                <i class="bi bi-arrow-repeat text-blue-300 text-xl"></i>
                                <div>
                                    <p class="text-xs text-blue-200 font-medium">Status</p>
                                    <p class="text-white font-black">Dikembalikan: {{ $alatKembali }}/{{ $totalAlat }}
                                    </p>
                                </div>
                            </div>
                        @elseif($peminjaman->isLate())
                            <div
                                class="inline-flex items-center gap-2 px-5 py-3 bg-white/20 backdrop-blur-lg rounded-xl border border-white/30 shadow-lg animate-pulse">
                                <i class="bi bi-exclamation-circle-fill text-red-300 text-xl"></i>
                                <div>
                                    <p class="text-xs text-red-200 font-medium">Status</p>
                                    <p class="text-white font-black">Terlambat</p>
                                </div>
                            </div>
                        @else
                            <div
                                class="inline-flex items-center gap-2 px-5 py-3 bg-white/20 backdrop-blur-lg rounded-xl border border-white/30 shadow-lg">
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
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="bi bi-calendar-event text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-black text-gray-900">Informasi Waktu</h3>
                                    <p class="text-sm text-gray-500 font-medium">Timeline peminjaman alat</p>
                                </div>
                            </div>

                            {{-- ✅ TOMBOL EXTEND (HANYA MUNCUL JIKA STATUS = DIPINJAM) --}}
                            @if ($peminjaman->status === 'dipinjam' || $peminjaman->status === 'sebagian_dikembalikan' || $peminjaman->status === 'terlambat')
                                <button type="button" onclick="openExtendModal()"
                                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-orange-500/50 transition-all">
                                    <i class="bi bi-calendar-plus text-lg"></i>
                                    Perpanjang Waktu
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-5">
                            {{-- Tanggal Pinjam --}}
                            <div
                                class="flex items-start gap-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-100">
                                <div
                                    class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="bi bi-box-arrow-right text-white text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Tanggal Pinjam
                                    </p>
                                    <p class="text-lg font-black text-gray-900">
                                        {{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
                                    <p class="text-sm text-gray-500 font-medium mt-1">
                                        {{ $peminjaman->tanggal_pinjam->diffForHumans() }}</p>
                                </div>
                            </div>

                            {{-- Tanggal Kembali Rencana --}}
                            <div
                                class="flex items-start gap-4 p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-2xl border border-orange-100">
                                <div
                                    class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="bi bi-calendar-check text-white text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Rencana Kembali
                                    </p>
                                    <p class="text-lg font-black text-gray-900">
                                        {{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}</p>
                                    @if ($peminjaman->status === 'dipinjam')
                                        @if ($peminjaman->isLate())
                                            <div
                                                class="inline-flex items-center gap-1 mt-2 px-3 py-1 bg-red-600 text-white text-xs font-bold rounded-lg animate-pulse">
                                                <i class="bi bi-exclamation-triangle-fill"></i>
                                                Terlambat {{ $peminjaman->tanggal_kembali_rencana->diffForHumans() }}
                                            </div>
                                        @else
                                            <p class="text-sm text-orange-600 font-semibold mt-1">
                                                <i class="bi bi-clock"></i>
                                                {{ $peminjaman->tanggal_kembali_rencana->diffForHumans() }}
                                            </p>
                                        @endif
                                    @else
                                        <p class="text-sm text-orange-600 font-semibold mt-1">
                                            <i class="bi bi-clock"></i>
                                            {{ $peminjaman->tanggal_kembali_rencana->diffForHumans() }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- Tanggal Kembali Aktual --}}
                            @if ($peminjaman->status === 'dikembalikan' && $peminjaman->tanggal_kembali_aktual)
                                <div
                                    class="flex items-start gap-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl border border-green-100">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="bi bi-box-arrow-in-left text-white text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Tanggal
                                            Dikembalikan</p>
                                        <p class="text-lg font-black text-gray-900">
                                            {{ $peminjaman->tanggal_kembali_aktual->format('d M Y') }}</p>
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
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
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
                                <label
                                    class="flex items-center gap-2 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    <i class="bi bi-person text-purple-500"></i>
                                    Nama Lengkap
                                </label>
                                <p class="text-base font-bold text-gray-900">{{ $peminjaman->nama_lengkap }}</p>
                            </div>
                            <div class="space-y-1">
                                <label
                                    class="flex items-center gap-2 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    <i class="bi bi-credit-card text-purple-500"></i>
                                    NIP
                                </label>
                                <p class="text-base font-bold text-gray-900">{{ $peminjaman->nip }}</p>
                            </div>
                            <div class="space-y-1">
                                <label
                                    class="flex items-center gap-2 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    <i class="bi bi-building text-purple-500"></i>
                                    Departemen
                                </label>
                                <p class="text-base font-bold text-gray-900">{{ $peminjaman->departemen }}</p>
                            </div>
                            <div class="space-y-1">
                                <label
                                    class="flex items-center gap-2 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    <i class="bi bi-envelope text-purple-500"></i>
                                    Email
                                </label>
                                <a href="mailto:{{ $peminjaman->email }}"
                                    class="text-base font-bold text-blue-600 hover:text-blue-700 hover:underline">
                                    {{ $peminjaman->email }}
                                </a>
                            </div>
                            <div class="space-y-1">
                                <label
                                    class="flex items-center gap-2 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    <i class="bi bi-telephone text-purple-500"></i>
                                    Telepon
                                </label>
                                <a href="tel:{{ $peminjaman->telepon }}"
                                    class="text-base font-bold text-blue-600 hover:text-blue-700 hover:underline">
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
                                <div
                                    class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="bi bi-box-seam text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-black text-gray-900">Daftar Alat</h3>
                                    <p class="text-sm text-gray-500 font-medium">Alat yang dipinjam</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 font-bold">Total Unit</p>
                                <p class="text-2xl font-black text-indigo-600">{{ $peminjaman->details->sum('jumlah') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach ($peminjaman->details as $index => $detail)
                                <div
                                    class="group relative bg-gradient-to-r from-gray-50 to-blue-50/30 rounded-2xl p-5 border border-gray-100 hover:shadow-lg hover:border-blue-200 transition-all duration-300">
                                    {{-- Number Badge --}}
                                    <div
                                        class="absolute -left-3 -top-3 w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg text-white font-black">
                                        {{ $index + 1 }}
                                    </div>

                                    {{-- Status Badge Kembali/Belum --}}
                                    <div class="absolute -right-3 -top-3">
                                        @if ($detail->kondisi_alat_kembali)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-black rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-lg">
                                                <i class="bi bi-check-circle-fill"></i>
                                                Sudah Kembali
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-black rounded-xl bg-gradient-to-r from-orange-500 to-red-600 text-white shadow-lg">
                                                <i class="bi bi-clock-fill"></i>
                                                Belum Kembali
                                            </span>
                                        @endif
                                    </div>

                                    <div class="ml-4">
                                        {{-- Nama & Kode Alat --}}
                                        <div class="mb-4">
                                            <h4 class="text-lg font-black text-gray-900 mb-2">{{ $detail->nama_alat }}
                                            </h4>
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-lg bg-blue-100 text-blue-700 border border-blue-200">
                                                    <i class="bi bi-upc-scan"></i>
                                                    {{ $detail->kode_alat }}
                                                </span>
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-black rounded-lg bg-gradient-to-r from-orange-400 to-orange-500 text-white shadow-lg">
                                                    <i class="bi bi-box"></i>
                                                    {{ $detail->jumlah }} Unit
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Kondisi --}}
                                        <div class="space-y-3 pt-4 border-t border-gray-200">
                                            <div class="flex items-center gap-3">
                                                <span class="text-sm font-bold text-gray-600 w-32">Kondisi Pinjam:</span>
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1 text-sm font-bold rounded-lg
                                @if ($detail->kondisi_alat === 'baik') bg-green-100 text-green-700
                                @elseif($detail->kondisi_alat === 'rusak_ringan') bg-yellow-100 text-yellow-700
                                @elseif($detail->kondisi_alat === 'rusak_berat') bg-red-100 text-red-700
                                @else bg-gray-100 text-gray-700 @endif">
                                                    <i class="bi bi-tools"></i>
                                                    {{ \App\Models\Alat::kondisiOptions()[$detail->kondisi_alat] ?? $detail->kondisi_alat }}
                                                </span>
                                            </div>

                                            @if ($detail->kondisi_alat_kembali)
                                                <div class="flex items-center gap-3">
                                                    <span class="text-sm font-bold text-gray-600 w-32">Kondisi
                                                        Kembali:</span>
                                                    <span
                                                        class="inline-flex items-center gap-1.5 px-3 py-1 text-sm font-bold rounded-lg
                                    @if ($detail->kondisi_alat_kembali === 'baik') bg-green-100 text-green-700
                                    @elseif($detail->kondisi_alat_kembali === 'rusak_ringan') bg-yellow-100 text-yellow-700
                                    @elseif($detail->kondisi_alat_kembali === 'rusak_berat') bg-red-100 text-red-700
                                    @else bg-gray-100 text-gray-700 @endif">
                                                        <i class="bi bi-tools"></i>
                                                        {{ \App\Models\Alat::kondisiOptions()[$detail->kondisi_alat_kembali] ?? $detail->kondisi_alat_kembali }}
                                                    </span>
                                                </div>

                                                @if ($detail->keterangan)
                                                    <div class="mt-3 p-3 bg-blue-50 rounded-xl border border-blue-100">
                                                        <p class="text-xs font-bold text-gray-600 mb-1">
                                                            <i class="bi bi-chat-left-text text-blue-600"></i>
                                                            Keterangan:
                                                        </p>
                                                        <p class="text-sm text-gray-700 italic">{{ $detail->keterangan }}
                                                        </p>
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

                {{-- BERITA ACARA / DOKUMEN PENGEMBALIAN --}}
                @if ($peminjaman->dokumen->count() > 0)
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                        <div class="bg-gradient-to-r from-gray-50 to-amber-50 px-6 py-4 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="bi bi-file-earmark-pdf text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-black text-gray-900">Berita Acara & Dokumen</h3>
                                        <p class="text-sm text-gray-500 font-medium">Dokumen terkait pengembalian</p>
                                    </div>
                                </div>
                                <div class="px-3 py-1 bg-amber-100 rounded-full">
                                    <p class="text-xs font-bold text-amber-700">{{ $peminjaman->dokumen->count() }} Dokumen</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                @foreach ($peminjaman->dokumen as $index => $dokumen)
                                    @php
                                        $extension = pathinfo($dokumen->dokumen_path, PATHINFO_EXTENSION);
                                        $isPDF = strtolower($extension) === 'pdf';
                                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png']);
                                        $isDoc = in_array(strtolower($extension), ['doc', 'docx']);
                                    @endphp

                                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4 border-2 border-amber-200 hover:shadow-lg transition-all">
                                        <div class="flex items-start gap-4">
                                            {{-- Icon --}}
                                            <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                                                @if ($isPDF)
                                                    <i class="bi bi-file-pdf text-white text-2xl"></i>
                                                @elseif ($isImage)
                                                    <i class="bi bi-file-image text-white text-2xl"></i>
                                                @elseif ($isDoc)
                                                    <i class="bi bi-file-word text-white text-2xl"></i>
                                                @else
                                                    <i class="bi bi-file-earmark text-white text-2xl"></i>
                                                @endif
                                            </div>

                                            {{-- Info --}}
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-start justify-between gap-2 mb-2">
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-xs font-bold text-gray-600 uppercase mb-1">Dokumen #{{ $index + 1 }}</p>
                                                        <p class="text-sm font-black text-gray-900 truncate">
                                                            {{ $dokumen->nama_dokumen ?? 'Berita Acara Kerusakan' }}
                                                        </p>
                                                    </div>
                                                    <span class="px-2 py-1 bg-amber-200 text-amber-800 text-xs font-bold rounded-lg uppercase">
                                                        {{ strtoupper($extension) }}
                                                    </span>
                                                </div>

                                                @if ($dokumen->keterangan)
                                                    <p class="text-xs text-gray-600 mb-2 line-clamp-2">
                                                        <i class="bi bi-chat-text text-amber-600"></i>
                                                        {{ $dokumen->keterangan }}
                                                    </p>
                                                @endif

                                                <p class="text-xs text-gray-500 font-medium mb-3">
                                                    <i class="bi bi-calendar3"></i>
                                                    {{ $dokumen->created_at->format('d M Y H:i') }}
                                                </p>

                                                {{-- Action Buttons --}}
                                                <div class="flex gap-2">
                                                    @if ($isPDF)
                                                        <button onclick="previewPDF('{{ asset($dokumen->dokumen_path) }}')"
                                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:shadow-lg transition-all text-xs font-bold">
                                                            <i class="bi bi-eye"></i>
                                                            Preview
                                                        </button>
                                                    @elseif ($isImage)
                                                        <button onclick="openImageModal('{{ asset($dokumen->dokumen_path) }}', 'Dokumen #{{ $index + 1 }}')"
                                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:shadow-lg transition-all text-xs font-bold">
                                                            <i class="bi bi-eye"></i>
                                                            Lihat
                                                        </button>
                                                    @endif

                                                    <a href="{{ asset($dokumen->dokumen_path) }}" download
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:shadow-lg transition-all text-xs font-bold">
                                                        <i class="bi bi-download"></i>
                                                        Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Info --}}
                            <div class="mt-4 p-3 bg-blue-50 rounded-xl border border-blue-100">
                                <p class="text-xs text-blue-800 font-medium">
                                    <i class="bi bi-info-circle-fill text-blue-600"></i>
                                    Dokumen-dokumen ini terkait dengan pengembalian alat yang rusak atau berbeda kondisi
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            {{-- Right Column - Sidebar --}}
            <div class="space-y-6">

                {{-- Keperluan --}}
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-gray-50 to-green-50 px-6 py-4 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
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
                @if ($peminjaman->foto_peminjaman)
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                        <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-6 py-4 border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
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
                                <img src="{{ asset($peminjaman->foto_peminjaman) }}" alt="Foto Peminjaman"
                                    class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500"
                                    onerror="this.parentNode.innerHTML='<div class=\'flex items-center justify-center h-48 bg-gray-100\'><i class=\'bi bi-image text-gray-400 text-5xl\'></i></div>'">
                                <div
                                    class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-all duration-300 flex items-center justify-center">
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
                @if (($peminjaman->status === 'dikembalikan' || $peminjaman->status === 'sebagian_dikembalikan')&& $peminjaman->fotoPengembalian->count() > 0)
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                        <div class="bg-gradient-to-r from-gray-50 to-green-50 px-6 py-4 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="bi bi-camera-fill text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-black text-gray-900">Foto Pengembalian</h3>
                                        <p class="text-sm text-gray-500 font-medium">Dokumentasi pengembalian</p>
                                    </div>
                                </div>
                                <div class="px-3 py-1 bg-green-100 rounded-full">
                                    <p class="text-xs font-bold text-green-700">{{ $peminjaman->fotoPengembalian->count() }} Foto</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach ($peminjaman->fotoPengembalian as $index => $foto)
                                    <div class="relative">
                                        <div class="group relative cursor-pointer rounded-xl overflow-hidden border-2 border-gray-200 hover:border-green-500 transition-all duration-300 hover:shadow-xl"
                                            onclick="openImageModal('{{ asset($foto->foto_path) }}', 'Foto Pengembalian #{{ $index + 1 }}')">
                                            <img src="{{ asset($foto->foto_path) }}" alt="Foto Pengembalian {{ $index + 1 }}"
                                                class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500"
                                                onerror="this.parentNode.innerHTML='<div class=\'flex items-center justify-center h-48 bg-gray-100\'><i class=\'bi bi-image text-gray-400 text-3xl\'></i></div>'">
                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-all duration-300 flex items-center justify-center">
                                                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                    <div class="w-10 h-10 bg-white/90 rounded-full flex items-center justify-center">
                                                        <i class="bi bi-zoom-in text-gray-900 text-lg"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Number Badge --}}
                                            <div class="absolute top-2 left-2 w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center shadow-lg">
                                                <span class="text-white font-black text-sm">{{ $index + 1 }}</span>
                                            </div>
                                        </div>
                                        @if ($foto->keterangan)
                                            <p class="text-xs text-gray-600 mt-2 line-clamp-2">
                                                <i class="bi bi-chat-text text-green-600"></i>
                                                {{ $foto->keterangan }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-xs text-center text-gray-500 font-medium mt-4">
                                <i class="bi bi-hand-index"></i> Klik foto untuk memperbesar
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

            {{-- @if ($peminjaman->status === 'dipinjam')
                <a href="{{ route('peminjaman.kembalikan', $peminjaman->id) }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:shadow-lg hover:shadow-green-500/50 transition-all font-bold hover:-translate-y-0.5">
                    <i class="bi bi-arrow-return-left"></i>
                    <span>Proses Pengembalian</span>
                </a>
            @endif --}}
        </div>
    </div>

    {{-- Premium Image Modal --}}
    <div id="imageModal"
        class="hidden fixed inset-0 bg-black/90 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-fadeIn"
        onclick="closeImageModal()">
        <div class="relative max-w-5xl w-full" onclick="event.stopPropagation()">
            <button onclick="closeImageModal()"
                class="absolute -top-12 right-0 w-10 h-10 bg-white/10 hover:bg-white/20 backdrop-blur-lg rounded-full flex items-center justify-center text-white transition-all hover:scale-110">
                <i class="bi bi-x-lg text-xl"></i>
            </button>

            <div class="bg-white rounded-3xl overflow-hidden shadow-2xl">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <h3 id="modalImageTitle" class="text-xl font-black text-white"></h3>
                </div>
                <div class="relative bg-gray-900 flex items-center justify-center" style="max-height: 75vh;">
                    <img id="modalImage" src="" alt=""
                        class="max-w-full max-h-[75vh] w-auto h-auto object-contain">
                </div>
                <div class="bg-gray-50 px-6 py-4 flex items-center justify-between">
                    <p class="text-sm text-gray-600 font-medium">
                        <i class="bi bi-info-circle text-blue-600"></i>
                        Gunakan ESC untuk menutup
                    </p>
                    <button onclick="closeImageModal()"
                        class="px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-lg hover:shadow-lg transition-all font-semibold">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- PDF Preview Modal --}}
    <div id="pdfModal"
        class="hidden fixed inset-0 bg-black/90 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-fadeIn"
        onclick="closePDFModal()">
        <div class="relative max-w-6xl w-full h-[90vh]" onclick="event.stopPropagation()">
            <button onclick="closePDFModal()"
                class="absolute -top-12 right-0 w-10 h-10 bg-white/10 hover:bg-white/20 backdrop-blur-lg rounded-full flex items-center justify-center text-white transition-all hover:scale-110">
                <i class="bi bi-x-lg text-xl"></i>
            </button>

            <div class="bg-white rounded-3xl overflow-hidden shadow-2xl h-full flex flex-col">
                <div class="bg-gradient-to-r from-amber-600 to-orange-600 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-xl font-black text-white">Preview Berita Acara</h3>
                    <a id="pdfDownloadLink" href="" download
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-lg rounded-lg text-white font-bold transition-all">
                        <i class="bi bi-download"></i>
                        Download
                    </a>
                </div>
                <div class="flex-1 bg-gray-100">
                    <iframe id="pdfViewer" src="" class="w-full h-full"></iframe>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================================ --}}
    {{-- ✅ MODAL EXTEND PEMINJAMAN (TARUH DI AKHIR FILE SEBELUM @endsection) --}}
    {{-- ============================================================================ --}}

    <!-- Modal Extend Peminjaman -->
    <div id="extendModal"
        class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-fadeIn">
        <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full overflow-hidden" onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-orange-500 to-red-500 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center">
                            <i class="bi bi-calendar-plus text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-white">Perpanjang Waktu Peminjaman</h3>
                            <p class="text-xs text-orange-100">Ubah tanggal rencana pengembalian</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeExtendModal()"
                        class="text-white hover:text-gray-200 transition-all">
                        <i class="bi bi-x-lg text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('peminjaman.extend', $peminjaman->id) }}" method="POST" id="formExtend">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-6">
                    <!-- Info Current -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-200">
                        <div class="flex items-start gap-3">
                            <i class="bi bi-info-circle-fill text-blue-600 text-xl mt-0.5"></i>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-gray-600 uppercase mb-1">Tanggal Rencana Saat Ini</p>
                                <p class="text-lg font-black text-gray-900">
                                    {{ $peminjaman->tanggal_kembali_rencana->format('d F Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Input New Date -->
                    <div>
                        <label for="tanggal_kembali_rencana_baru" class="block text-sm font-bold text-gray-700 mb-2">
                            Tanggal Rencana Baru <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_kembali_rencana_baru" name="tanggal_kembali_rencana_baru"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all"
                            min="{{ now()->addDay()->format('Y-m-d') }}" required>
                        <p class="mt-2 text-xs text-gray-500">
                            <i class="bi bi-exclamation-circle"></i>
                            Minimal 1 hari dari hari ini
                        </p>
                    </div>

                    <!-- Alasan -->
                    <div>
                        <label for="alasan_extend" class="block text-sm font-bold text-gray-700 mb-2">
                            Alasan Perpanjangan
                        </label>
                        <textarea id="alasan_extend" name="alasan_extend" rows="3"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all"
                            placeholder="Jelaskan alasan perpanjangan peminjaman..."></textarea>
                    </div>

                    <!-- Warning -->
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
                        <div class="flex items-start gap-3">
                            <i class="bi bi-exclamation-triangle-fill text-yellow-600 text-xl"></i>
                            <div>
                                <p class="text-sm font-bold text-yellow-900">Perhatian!</p>
                                <p class="text-xs text-yellow-700 mt-1">
                                    Perpanjangan akan tercatat dalam histori peminjaman. Pastikan sudah berkoordinasi dengan
                                    admin.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-4 flex gap-3">
                    <button type="button" onclick="closeExtendModal()"
                        class="flex-1 px-4 py-3 bg-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-300 transition-all">
                        <i class="bi bi-x-circle"></i>
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-xl font-bold hover:shadow-lg hover:shadow-orange-500/50 transition-all">
                        <i class="bi bi-check-circle"></i>
                        Perpanjang
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        // Image Modal Functions
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

        // PDF Modal Functions
        function previewPDF(pdfUrl) {
            const modal = document.getElementById('pdfModal');
            const pdfViewer = document.getElementById('pdfViewer');
            const downloadLink = document.getElementById('pdfDownloadLink');

            pdfViewer.src = pdfUrl;
            downloadLink.href = pdfUrl;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closePDFModal() {
            const modal = document.getElementById('pdfModal');
            const pdfViewer = document.getElementById('pdfViewer');

            modal.classList.add('hidden');
            pdfViewer.src = '';
            document.body.style.overflow = 'auto';
        }

        // Close modals with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
                closePDFModal();
            }
        });

        // Prevent click propagation on image and PDF viewer
        document.getElementById('modalImage')?.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        document.getElementById('pdfViewer')?.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        // Open Modal
        function openExtendModal() {
            document.getElementById('extendModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Close Modal
        function closeExtendModal() {
            document.getElementById('extendModal').classList.add('hidden');
            document.body.style.overflow = 'auto';

            // Reset form
            document.getElementById('formExtend').reset();
        }

        // Close modal dengan ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeExtendModal();
            }
        });

        // Close modal jika klik backdrop
        document.getElementById('extendModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeExtendModal();
            }
        });

        // Validasi form sebelum submit
        document.getElementById('formExtend')?.addEventListener('submit', function(e) {
            const tanggalBaru = new Date(document.getElementById('tanggal_kembali_rencana_baru').value);
            const tanggalLama = new Date('{{ $peminjaman->tanggal_kembali_rencana->format('Y-m-d') }}');

            if (tanggalBaru <= tanggalLama) {
                e.preventDefault();
                alert('Tanggal baru harus lebih dari tanggal rencana saat ini!');
                return false;
            }

            const konfirmasi = confirm('Apakah Anda yakin ingin memperpanjang waktu peminjaman?');
            if (!konfirmasi) {
                e.preventDefault();
                return false;
            }
        });
    </script>

    <style>
        /* Animations */
        @keyframes blob {

            0%,
            100% {
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

            .space-y-6,
            .space-y-6 * {
                visibility: visible;
            }

            .space-y-6 {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            button,
            nav,
            .hover\:shadow-lg,
            [onclick] {
                display: none !important;
            }

            .bg-gradient-to-br,
            .bg-gradient-to-r {
                background: white !important;
                border: 1px solid #e5e7eb !important;
            }
        }
    </style>
@endsection
