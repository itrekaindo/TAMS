@extends('layouts.public')
@section('title', 'Form Pengembalian Alat')
@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Alert Progress Pengembalian --}}
    @if($peminjaman->status === 'sebagian_dikembalikan')
    <div class="bg-gradient-to-r from-blue-500 to-cyan-500 rounded-3xl shadow-xl overflow-hidden mb-6">
        <div class="px-8 py-6 text-white">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center">
                    <i class="bi bi-info-circle-fill text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black">Pengembalian Bertahap</h3>
                    <p class="text-blue-100 text-sm">Anda sudah pernah mengembalikan sebagian alat sebelumnya</p>
                </div>
            </div>
            {{-- Progress Bar --}}
            <div class="space-y-2">
                <div class="flex justify-between text-sm font-semibold">
                    <span>Progress Pengembalian</span>
                    <span>{{ number_format($peminjaman->persentase_pengembalian, 1) }}%</span>
                </div>
                <div class="h-4 bg-white/20 backdrop-blur-lg rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-green-400 to-emerald-400 rounded-full transition-all duration-500"
                        style="width: {{ $peminjaman->persentase_pengembalian }}%"></div>
                </div>
                <div class="flex justify-between text-sm text-blue-100">
                    <span>{{ $peminjaman->total_item_dikembalikan }} unit sudah dikembalikan</span>
                    <span>{{ $peminjaman->total_item_belum_kembali }} unit tersisa</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Header Card --}}
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 px-8 py-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center shadow-xl">
                    <i class="bi bi-arrow-return-left text-white text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-black text-white">Form Pengembalian Alat</h1>
                    <p class="text-green-100 text-sm font-medium mt-1">
                        @if($peminjaman->status === 'sebagian_dikembalikan')
                            Lanjutkan pengembalian alat yang tersisa
                        @else
                            Proses pengembalian alat yang telah dipinjam
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Info Peminjaman Card --}}
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-3xl border-2 border-blue-200 p-8 mb-6 shadow-xl">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="bi bi-info-circle-fill text-white text-xl"></i>
            </div>
            <h2 class="text-xl font-black text-gray-900">Informasi Peminjaman</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            {{-- Left Column --}}
            <div class="space-y-3">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-upc-scan text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase">Kode Peminjaman</p>
                        <p class="text-sm font-black text-gray-900 font-mono">{{ $peminjaman->kode_peminjaman }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-person-fill text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase">Nama Peminjam</p>
                        <p class="text-sm font-bold text-gray-900">{{ $peminjaman->peminjam->nama_lengkap }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-person-badge text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase">NIP</p>
                        <p class="text-sm font-bold text-gray-900">{{ $peminjaman->peminjam->nip }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-building text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase">Departemen</p>
                        <p class="text-sm font-bold text-gray-900">{{ $peminjaman->peminjam->departemen }}</p>
                    </div>
                </div>
            </div>
            {{-- Right Column --}}
            <div class="space-y-3">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-calendar-event text-indigo-600"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase">Tanggal Pinjam</p>
                        <p class="text-sm font-bold text-gray-900">
                            {{ $peminjaman->tanggal_pinjam->isoFormat('D MMMM Y') }}
                        </p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-calendar-check text-indigo-600"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase">Rencana Kembali</p>
                        <p class="text-sm font-bold text-gray-900">
                            {{ $peminjaman->tanggal_kembali_rencana->isoFormat('D MMMM Y') }}
                        </p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-box-seam text-indigo-600"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase">Total Alat</p>
                        <p class="text-sm font-bold text-gray-900">{{ $peminjaman->details->count() }} jenis alat</p>
                    </div>
                </div>
            </div>
        </div>
        {{-- Status Badge --}}
        <div class="pt-6 border-t-2 border-blue-200">
            @if ($peminjaman->isLate())
                <div class="flex items-start gap-3 p-4 bg-gradient-to-r from-red-500 to-pink-500 rounded-2xl shadow-lg">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-exclamation-triangle-fill text-white text-xl"></i>
                    </div>
                    <div class="text-white">
                        <p class="font-black text-base">Terlambat!</p>
                        <p class="text-sm text-red-100 mt-1">Sudah melewati tanggal rencana pengembalian</p>
                    </div>
                </div>
            @else
                <div class="flex items-start gap-3 p-4 bg-gradient-to-r from-green-500 to-emerald-500 rounded-2xl shadow-lg">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-check-circle-fill text-white text-xl"></i>
                    </div>
                    <div class="text-white">
                        <p class="font-black text-base">Tepat Waktu</p>
                        <p class="text-sm text-green-100 mt-1">Pengembalian sesuai jadwal</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Foto Peminjaman --}}
    @if ($peminjaman->foto_peminjaman)
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 p-8 mb-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="bi bi-image text-white text-xl"></i>
            </div>
            <h2 class="text-xl font-black text-gray-900">Foto Saat Peminjaman</h2>
        </div>
        <div class="flex justify-center">
            <img src="{{ asset($peminjaman->foto_peminjaman) }}" alt="Foto Peminjaman"
                class="max-w-md w-full rounded-2xl shadow-2xl border-4 border-white">
        </div>
    </div>
    @endif

    {{-- Form Pengembalian --}}
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
        <form action="{{ route('pengembalian.submit', $peminjaman->id) }}" method="POST" enctype="multipart/form-data"
            id="formPengembalian" class="p-8 space-y-8">
            @csrf

            {{-- Daftar Alat Section --}}
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-box-seam text-white text-xl"></i>
                    </div>
                    <h2 class="text-xl font-black text-gray-900">Daftar Alat - Pilih yang Akan Dikembalikan</h2>
                </div>

                <div class="bg-gradient-to-r from-cyan-50 to-blue-50 rounded-2xl border-2 border-cyan-200 p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <i class="bi bi-info-circle-fill text-cyan-600 text-xl flex-shrink-0 mt-1"></i>
                        <div class="text-sm text-gray-700">
                            <p class="font-bold text-gray-900 mb-1">💡 Cara Pengembalian:</p>
                            <ul class="list-disc list-inside space-y-1 ml-2">
                                <li><strong>Centang checkbox</strong> pada alat yang ingin dikembalikan</li>
                                <li>Anda bisa mengembalikan <strong>sebagian atau semua</strong> alat sekaligus</li>
                                <li>Jika 1 alat dipinjam 5 unit, bisa dikembalikan 2 unit dulu, sisanya nanti</li>
                                <li>Alat yang belum dikembalikan bisa dikembalikan di lain waktu</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    @php
                        $hasItemsToReturn = false;
                    @endphp
                    @foreach ($peminjaman->details as $index => $detail)
                        @php
                            $sisaBelumKembali = $detail->jumlah - $detail->jumlah_dikembalikan;
                        @endphp
                        @if($sisaBelumKembali > 0)
                            @php $hasItemsToReturn = true; @endphp
                            <div class="alat-card bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl border-2 border-gray-200 overflow-hidden transition-all"
                                data-kondisi-pinjam="{{ $detail->kondisi_alat }}"
                                data-detail-id="{{ $detail->id }}">
                                {{-- Card Header dengan Checkbox --}}
                                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                                    <label class="flex items-center gap-4 cursor-pointer group">
                                        <input type="checkbox"
                                            class="item-checkbox w-6 h-6 text-green-600 bg-white/20 border-2 border-white/50 rounded-lg focus:ring-2 focus:ring-green-400 cursor-pointer transition-all"
                                            data-detail-id="{{ $detail->id }}"
                                            data-max-qty="{{ $sisaBelumKembali }}">
                                        <div class="flex-1 flex items-center gap-3 text-white">
                                            <div class="w-10 h-10 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                                <i class="bi bi-box text-lg"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-blue-100">Alat #{{ $index + 1 }}</p>
                                                <h3 class="text-lg font-black">{{ $detail->nama_alat }}</h3>
                                            </div>
                                        </div>
                                        @if($detail->status_item === 'sebagian_dikembalikan')
                                            <span class="px-3 py-1 bg-yellow-400 text-yellow-900 rounded-full text-xs font-bold">
                                                Sebagian Dikembalikan
                                            </span>
                                        @endif
                                    </label>
                                </div>

                                {{-- Card Body --}}
                                <div class="p-6 space-y-6">
                                    {{-- Info Alat --}}
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gray-200 rounded-xl flex items-center justify-center">
                                                <i class="bi bi-upc-scan text-gray-600"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold text-gray-500 uppercase">Kode Alat</p>
                                                <p class="text-sm font-black text-gray-900 font-mono">{{ $detail->kode_alat }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                                <i class="bi bi-123 text-blue-600"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold text-gray-500 uppercase">Total Dipinjam</p>
                                                <p class="text-sm font-black text-gray-900">{{ $detail->jumlah }} unit</p>
                                            </div>
                                        </div>
                                        @if($detail->jumlah_dikembalikan > 0)
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                                <i class="bi bi-check-circle text-green-600"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold text-gray-500 uppercase">Sudah Dikembalikan</p>
                                                <p class="text-sm font-black text-green-600">{{ $detail->jumlah_dikembalikan }} unit</p>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                                                <i class="bi bi-exclamation-circle text-orange-600"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold text-gray-500 uppercase">Belum Dikembalikan</p>
                                                <p class="text-sm font-black text-orange-600">{{ $sisaBelumKembali }} unit</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Form Input (Initially Hidden) --}}
                                    <div class="detail-form-wrapper" style="display: none;">
                                        <div class="bg-white rounded-xl p-5 border-2 border-blue-200 space-y-5">
                                            {{-- Jumlah & Kondisi --}}
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                                <div>
                                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                                        Jumlah yang Dikembalikan Sekarang <span class="text-red-500">*</span>
                                                    </label>
                                                    <div class="flex items-center gap-3">
                                                        <input type="number"
                                                            class="jumlah-input flex-1 px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-bold text-lg"
                                                            name="detail[{{ $detail->id }}][jumlah_dikembalikan]"
                                                            min="1"
                                                            max="{{ $sisaBelumKembali }}"
                                                            value="{{ old('detail.' . $detail->id . '.jumlah_dikembalikan', $sisaBelumKembali) }}"
                                                            disabled
                                                            required>
                                                        <span class="text-gray-500 font-semibold">dari {{ $sisaBelumKembali }} unit</span>
                                                    </div>
                                                    <p class="mt-2 text-xs text-gray-600">
                                                        <i class="bi bi-info-circle"></i>
                                                        Anda bisa mengembalikan sebagian (min: 1, max: {{ $sisaBelumKembali }})
                                                    </p>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                                        Kondisi Saat Dikembalikan <span class="text-red-500">*</span>
                                                    </label>
                                                    <select class="kondisi-select w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                                        name="detail[{{ $detail->id }}][kondisi_alat_kembali]"
                                                        data-detail-id="{{ $detail->id }}"
                                                        disabled
                                                        required>
                                                        <option value="">-- Pilih Kondisi --</option>
                                                        @foreach (\App\Models\Peminjaman::kondisiOptions() as $key => $value)
                                                            <option value="{{ $key }}"
                                                                {{ old('detail.' . $detail->id . '.kondisi_alat_kembali', $detail->kondisi_alat) == $key ? 'selected' : '' }}>
                                                                {{ $value }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <p class="mt-2 text-xs text-gray-600">
                                                        <i class="bi bi-tools"></i>
                                                        Kondisi saat dipinjam: <strong>{{ \App\Models\Peminjaman::kondisiOptions()[$detail->kondisi_alat] ?? $detail->kondisi_alat }}</strong>
                                                    </p>
                                                </div>
                                            </div>

                                            {{-- Keterangan --}}
                                            <div>
                                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                                    Keterangan (Opsional)
                                                </label>
                                                <textarea class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                                    name="detail[{{ $detail->id }}][keterangan]"
                                                    rows="3"
                                                    placeholder="Catatan: kerusakan, kehilangan komponen, atau informasi tambahan lainnya"
                                                    disabled>{{ old('detail.' . $detail->id . '.keterangan') }}</textarea>
                                            </div>

                                            {{-- Warning Kondisi --}}
                                            <div class="warning-kondisi hidden">
                                                <div class="flex items-start gap-3 p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded-lg">
                                                    <div class="flex-shrink-0 w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                                        <i class="bi bi-exclamation-triangle-fill text-yellow-600"></i>
                                                    </div>
                                                    <div>
                                                        <p class="font-bold text-yellow-900 text-sm">Peringatan!</p>
                                                        <p class="text-sm text-yellow-700 mt-1">
                                                            Kondisi alat saat dikembalikan berbeda dengan kondisi saat peminjaman.
                                                            Pastikan Anda telah mengisi keterangan dengan benar.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Item yang sudah dikembalikan semua --}}
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl border-2 border-green-300 p-6 opacity-60">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                                        <i class="bi bi-check-circle-fill text-white text-2xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-black text-gray-900">{{ $detail->nama_alat }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">
                                            <span class="font-semibold">{{ $detail->kode_alat }}</span> -
                                            Sudah dikembalikan semua ({{ $detail->jumlah }} unit)
                                        </p>
                                    </div>
                                    <span class="px-4 py-2 bg-green-500 text-white rounded-full text-sm font-bold">
                                        ✓ Selesai
                                    </span>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    @if(!$hasItemsToReturn)
                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 rounded-2xl p-8 text-center text-white">
                            <div class="w-20 h-20 bg-white/20 backdrop-blur-lg rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="bi bi-check-circle-fill text-4xl"></i>
                            </div>
                            <h3 class="text-2xl font-black mb-2">Semua Alat Sudah Dikembalikan!</h3>
                            <p class="text-green-100">Terima kasih telah mengembalikan semua alat tepat waktu.</p>
                        </div>
                    @endif
                </div>

                {{-- Item Selection Counter --}}
                <div id="selection-counter" class="mt-6 p-5 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl text-white hidden">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center">
                                <i class="bi bi-check2-square text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-blue-100">Alat yang dipilih untuk dikembalikan</p>
                                <p class="text-xl font-black"><span id="selected-count">0</span> alat</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-blue-100">Total unit</p>
                            <p class="text-xl font-black"><span id="total-units">0</span> unit</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t-2 border-gray-100"></div>

            {{-- Data Pengembalian Section --}}
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-clipboard-check text-white text-xl"></i>
                    </div>
                    <h2 class="text-xl font-black text-gray-900">Data Pengembalian</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Tanggal Pengembalian --}}
                    <div>
                        <label for="tanggal_kembali" class="block text-sm font-bold text-gray-700 mb-2">
                            Tanggal Pengembalian
                        </label>
                        <input type="text"
                            class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-xl text-gray-700 font-semibold cursor-not-allowed"
                            id="tanggal_kembali" value="{{ now()->isoFormat('D MMMM Y') }}" readonly>
                        <p class="mt-2 text-sm text-gray-500">Diisi otomatis saat pengembalian</p>
                    </div>

                    {{-- Upload Foto --}}
                    <div>
                        <label for="foto_pengembalian" class="block text-sm font-bold text-gray-700 mb-2">
                            Upload Foto Pengembalian <span class="text-red-500">*</span>
                        </label>
                        <div class="flex flex-col sm:flex-row gap-3 mb-4">
                            <button type="button" id="btnChooseFile"
                                class="hidden md:flex flex-1 items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl font-bold hover:shadow-lg hover:shadow-green-500/50 transition-all">
                                <i class="bi bi-image text-lg"></i> Pilih dari File
                            </button>
                            <button type="button" id="btnOpenCamera"
                                class="flex md:hidden flex-1 items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-bold hover:shadow-lg hover:shadow-blue-500/50 transition-all">
                                <i class="bi bi-camera text-lg"></i> Ambil Foto
                            </button>
                        </div>
                        <input type="file" id="foto_pengembalian" name="foto_pengembalian[]" accept="image/*" class="hidden" multiple required>
                        <p class="mt-2 text-sm text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
                        @error('foto_pengembalian')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Camera Modal --}}
                    <div id="cameraModal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4">
                        <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full overflow-hidden">
                            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4 flex items-center justify-between">
                                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                                    <i class="bi bi-camera-fill"></i> Ambil Foto Pengembalian
                                </h3>
                                <button type="button" id="btnCloseCamera" class="text-white hover:text-gray-200 transition-all">
                                    <i class="bi bi-x-lg text-2xl"></i>
                                </button>
                            </div>
                            <div class="p-6">
                                <div id="cameraView" class="relative">
                                    <video id="cameraStream" autoplay playsinline class="w-full rounded-2xl bg-gray-900"></video>
                                    <div class="mt-4 flex justify-center gap-3">
                                        <button type="button" id="btnCapture" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl font-bold hover:shadow-lg transition-all">
                                            <i class="bi bi-camera-fill text-xl"></i> Ambil Foto
                                        </button>
                                        <button type="button" id="btnCancelCamera" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-300 transition-all">
                                            <i class="bi bi-x-circle"></i> Batal
                                        </button>
                                    </div>
                                </div>
                                <div id="capturedView" class="hidden">
                                    <canvas id="captureCanvas" class="w-full rounded-2xl"></canvas>
                                    <div class="mt-4 flex justify-center gap-3">
                                        <button type="button" id="btnUsePhoto" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl font-bold hover:shadow-lg transition-all">
                                            <i class="bi bi-check-circle-fill text-xl"></i> Gunakan Foto
                                        </button>
                                        <button type="button" id="btnRetake" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-300 transition-all">
                                            <i class="bi bi-arrow-clockwise"></i> Ambil Ulang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Preview Image --}}
                    <div id="preview-container" class="md:col-span-2 hidden">
                        <p class="block text-sm font-bold text-gray-700 mb-2">Preview Foto:</p>
                        <div class="relative inline-block">
                            <img id="preview-image" src="" alt="Preview" class="max-w-md w-full rounded-2xl shadow-lg border-4 border-white">
                            <button type="button" id="btnRemovePreview"
                                class="absolute -top-3 -right-3 w-10 h-10 bg-red-500 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-red-600 transition-all">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                        <p class="mt-2 text-sm text-green-600 font-semibold flex items-center gap-1">
                            <i class="bi bi-check-circle-fill"></i>
                            <span id="photoSource">Foto berhasil dipilih</span>
                        </p>
                    </div>

                    {{-- Keterangan Umum --}}
                    <div class="md:col-span-2">
                        <label for="keterangan_pengembalian" class="block text-sm font-bold text-gray-700 mb-2">
                            Keterangan Umum Pengembalian (Opsional)
                        </label>
                        <textarea
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('keterangan_pengembalian') border-red-500 @enderror"
                            id="keterangan_pengembalian" name="keterangan_pengembalian" rows="4"
                            placeholder="Catatan umum tentang pengembalian alat yang dipilih">{{ old('keterangan_pengembalian') }}</textarea>
                        @error('keterangan_pengembalian')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Upload Surat Pernyataan Section (Hidden by default) --}}
            <div id="section-surat-pernyataan" class="hidden">
                <div class="border-t-2 border-gray-100"></div>
                <div class="bg-gradient-to-r from-red-50 to-orange-50 rounded-2xl border-2 border-red-300 mt-6 p-6 space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            <i class="bi bi-exclamation-triangle-fill text-white text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-black text-red-900 mb-2">Upload Berita Acara Kerusakan Diperlukan!</h3>
                            <p class="text-sm text-red-700 mb-4">
                                Terdapat alat yang dikembalikan dengan kondisi <strong>rusak atau berbeda</strong> dari kondisi saat peminjaman.
                                Anda <strong>WAJIB</strong> mengupload berita acara kerusakan yang telah diisi dan ditandatangani.
                            </p>

                            {{-- Kronologi Kerusakan --}}
                            <div class="space-y-4 mb-6">
                                <div>
                                    <label for="kronologi_kerusakan" class="block text-sm font-bold text-gray-900 mb-2">
                                        Kronologi Kerusakan <span class="text-red-600">* WAJIB</span>
                                    </label>
                                    <textarea
                                        id="kronologi_kerusakan"
                                        rows="4"
                                        class="w-full px-4 py-3 border-2 border-red-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all bg-white"
                                        placeholder="Jelaskan kronologi kejadian..."></textarea>
                                    <p class="mt-2 text-xs text-red-700">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        <strong>Wajib diisi!</strong> Kronologi akan digunakan dalam Berita Acara yang di-generate.
                                    </p>
                                </div>
                                <button type="button" id="btnGenerateBA"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl">
                                    <i class="bi bi-file-earmark-pdf text-lg"></i>
                                    Generate & Download Berita Acara (PDF)
                                </button>
                            </div>

                            {{-- Instruksi --}}
                            <div class="bg-white rounded-xl p-4 mb-6 border border-red-200">
                                <p class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2">
                                    <i class="bi bi-info-circle-fill text-blue-600"></i> Langkah-langkah:
                                </p>
                                <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
                                    <li>Isi kronologi kerusakan di atas</li>
                                    <li>Klik tombol "Generate & Download Berita Acara"</li>
                                    <li>Cetak dan tandatangani berita acara tersebut</li>
                                    <li>Scan atau foto berita acara yang sudah ditandatangani</li>
                                    <li>Upload file hasil scan/foto di form di bawah</li>
                                </ol>
                            </div>

                            {{-- Upload Field --}}
                            <div>
                                <label for="dokumen_ba" class="block text-sm font-bold text-gray-900 mb-2">
                                    Upload Berita Acara Kerusakan <span class="text-red-600">* WAJIB</span>
                                </label>
                                <input type="file"
                                    class="w-full px-4 py-3 border-2 border-red-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all bg-white @error('dokumen_ba') border-red-500 @enderror"
                                    id="dokumen_ba" name="dokumen_ba[]"
                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" multiple>
                                <p class="mt-2 text-xs text-gray-600">
                                    <i class="bi bi-info-circle"></i>
                                    Format: PDF, DOC, DOCX, JPG, JPEG, PNG. Maksimal 5MB
                                </p>
                                @error('dokumen_ba')
                                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                        <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                    </p>
                                @enderror
                                <div id="file-info" class="hidden mt-3 p-3 bg-green-50 border border-green-300 rounded-lg">
                                    <div class="flex items-center gap-2 text-green-700">
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span class="text-sm font-semibold">File terpilih: <span id="file-name"></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t-2 border-gray-100"></div>

            {{-- Pernyataan --}}
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border-2 border-blue-200">
                <label class="flex items-start gap-4 cursor-pointer group">
                    <input type="checkbox" id="pernyataan"
                        class="mt-1 w-5 h-5 text-blue-600 border-2 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 cursor-pointer"
                        required>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                            Saya menyatakan bahwa data yang saya masukkan adalah benar dan semua alat dikembalikan sesuai kondisi yang dilaporkan
                        </p>
                        <p class="text-xs text-gray-600 mt-2">
                            Dengan mencentang ini, Anda bertanggung jawab penuh atas kebenaran informasi yang diberikan.
                        </p>
                    </div>
                </label>
            </div>

            {{-- Submit Buttons --}}
            <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-6 border-t-2 border-gray-100">
                <a href="{{ route('pengembalian.cari') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-300 transition-all">
                    <i class="bi bi-x-circle text-lg"></i> Batal
                </a>
                <button type="submit" id="btnSubmit"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl font-bold hover:shadow-lg hover:shadow-green-500/50 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="bi bi-check-circle text-lg"></i> Proses Pengembalian
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// ========================================
// TOGGLE FORM INPUT BERDASARKAN CHECKBOX
// ========================================
document.addEventListener('DOMContentLoaded', function () {
    // Toggle form input saat checkbox diubah
    document.querySelectorAll('.item-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const card = this.closest('.alat-card');
            const wrapper = card.querySelector('.detail-form-wrapper');
            const inputs = wrapper.querySelectorAll('input, select, textarea');

            if (this.checked) {
                wrapper.style.display = 'block';
                inputs.forEach(input => input.disabled = false);
            } else {
                wrapper.style.display = 'none';
                inputs.forEach(input => input.disabled = true);
            }

            updateSelectionCounter();
            checkForDamage();
        });
    });

    // Update counter & total unit
    window.updateSelectionCounter = function () {
        const checkboxes = document.querySelectorAll('.item-checkbox:checked');
        const counter = document.getElementById('selection-counter');
        let totalUnits = 0;

        checkboxes.forEach(cb => {
            const maxQty = parseInt(cb.dataset.maxQty) || 0;
            const input = cb.closest('.alat-card').querySelector('.jumlah-input');
            const qty = input ? parseInt(input.value) || 0 : maxQty;
            totalUnits += qty;
        });

        const count = checkboxes.length;
        document.getElementById('selected-count').textContent = count;
        document.getElementById('total-units').textContent = totalUnits;

        if (count > 0) {
            counter.classList.remove('hidden');
        } else {
            counter.classList.add('hidden');
        }

        const submitBtn = document.getElementById('btnSubmit');
        if (submitBtn) submitBtn.disabled = (count === 0);
    };

    // Sync jumlah input
    document.querySelectorAll('.jumlah-input').forEach(input => {
        input.addEventListener('input', function () {
            const max = parseInt(this.max);
            let val = parseInt(this.value) || 0;
            if (val < 1) val = 1;
            if (val > max) val = max;
            this.value = val;
            updateSelectionCounter();
        });
    });

    // Restore state from old() input
    document.querySelectorAll('.item-checkbox').forEach(checkbox => {
        const card = checkbox.closest('.alat-card');
        const hasValue = card.querySelector('.kondisi-select').value ||
                         card.querySelector('.jumlah-input').value;

        if (hasValue) {
            checkbox.checked = true;
            const wrapper = card.querySelector('.detail-form-wrapper');
            wrapper.style.display = 'block';
            wrapper.querySelectorAll('input, select, textarea').forEach(el => el.disabled = false);
        }
    });

    updateSelectionCounter();
    checkForDamage();
});

// ========================================
// CAMERA & FILE UPLOAD FUNCTIONALITY
// ========================================
(function () {
    let stream = null;
    let capturedImageBlob = null;
    const btnChooseFile = document.getElementById('btnChooseFile');
    const btnOpenCamera = document.getElementById('btnOpenCamera');
    const fileInput = document.getElementById('foto_pengembalian');
    const cameraModal = document.getElementById('cameraModal');
    const btnCloseCamera = document.getElementById('btnCloseCamera');
    const btnCancelCamera = document.getElementById('btnCancelCamera');
    const cameraStream = document.getElementById('cameraStream');
    const btnCapture = document.getElementById('btnCapture');
    const btnRetake = document.getElementById('btnRetake');
    const btnUsePhoto = document.getElementById('btnUsePhoto');
    const cameraView = document.getElementById('cameraView');
    const capturedView = document.getElementById('capturedView');
    const captureCanvas = document.getElementById('captureCanvas');
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');
    const btnRemovePreview = document.getElementById('btnRemovePreview');
    const photoSource = document.getElementById('photoSource');

    // ✅ Button Choose File
    if (btnChooseFile) {
        btnChooseFile.addEventListener('click', () => fileInput.click());
    }

    // ✅ File Input Change - Handle Multiple Files
    if (fileInput) {
        fileInput.addEventListener('change', function () {
            const files = Array.from(this.files);

            if (files.length === 0) return;

            // Validasi ukuran setiap file
            for (let file of files) {
                if (file.size > 2048000) {
                    alert(`File ${file.name} terlalu besar! Maksimal 2MB per file`);
                    this.value = '';
                    return;
                }
            }

            // Preview file pertama
            const file = files[0];
            const reader = new FileReader();
            reader.onload = e => {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');

                // Update text untuk multiple files
                if (files.length > 1) {
                    const fileNames = files.map(f => f.name).join(', ');
                    photoSource.textContent = `${files.length} foto dipilih: ${fileNames}`;
                } else {
                    photoSource.textContent = 'Foto dari file: ' + file.name;
                }
            };
            reader.readAsDataURL(file);
        });
    }

    // ✅ Open Camera
    if (btnOpenCamera) {
        btnOpenCamera.addEventListener('click', async () => {
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment',
                        width: { ideal: 1920 },
                        height: { ideal: 1080 }
                    }
                });
                cameraStream.srcObject = stream;
                cameraModal.classList.remove('hidden');
                cameraView.classList.remove('hidden');
                capturedView.classList.add('hidden');
            } catch (err) {
                console.error('Camera error:', err);
                alert('Tidak dapat mengakses kamera. Pastikan izin kamera diaktifkan.');
            }
        });
    }

    // ✅ Close Camera Function
    function closeCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
        cameraModal.classList.add('hidden');
        cameraView.classList.remove('hidden');
        capturedView.classList.add('hidden');
    }

    // ✅ Close Camera Buttons
    [btnCloseCamera, btnCancelCamera].forEach(btn => {
        if (btn) {
            btn.addEventListener('click', () => closeCamera());
        }
    });

    // Close modal when clicking outside
    if (cameraModal) {
        cameraModal.addEventListener('click', (e) => {
            if (e.target === cameraModal) {
                closeCamera();
            }
        });
    }

    // ✅ Capture Photo
    if (btnCapture) {
        btnCapture.addEventListener('click', () => {
            const video = cameraStream;
            const canvas = captureCanvas;
            const ctx = canvas.getContext('2d');

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            cameraView.classList.add('hidden');
            capturedView.classList.remove('hidden');

            canvas.toBlob(blob => {
                capturedImageBlob = blob;
            }, 'image/jpeg', 0.95);
        });
    }

    // ✅ Retake Photo
    if (btnRetake) {
        btnRetake.addEventListener('click', () => {
            cameraView.classList.remove('hidden');
            capturedView.classList.add('hidden');
            capturedImageBlob = null;
        });
    }

    // ✅ Use Photo from Camera
    if (btnUsePhoto) {
        btnUsePhoto.addEventListener('click', () => {
            if (!capturedImageBlob) return;

            const file = new File(
                [capturedImageBlob],
                'pengembalian-' + Date.now() + '.jpg',
                { type: 'image/jpeg' }
            );

            // ✅ Create DataTransfer to handle multiple files
            const dt = new DataTransfer();

            // Tambahkan existing files dulu (jika ada)
            if (fileInput.files.length > 0) {
                Array.from(fileInput.files).forEach(f => dt.items.add(f));
            }

            // Tambahkan foto baru dari kamera
            dt.items.add(file);

            // Set ke input file
            fileInput.files = dt.files;

            // Preview foto terakhir yang ditambahkan
            const reader = new FileReader();
            reader.onload = e => {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');

                // Update text
                if (dt.files.length > 1) {
                    photoSource.textContent = `${dt.files.length} foto (termasuk dari kamera)`;
                } else {
                    photoSource.textContent = 'Foto dari kamera';
                }
            };
            reader.readAsDataURL(file);

            closeCamera();
        });
    }

    // ✅ Remove Preview
    if (btnRemovePreview) {
        btnRemovePreview.addEventListener('click', () => {
            fileInput.value = '';
            previewContainer.classList.add('hidden');
            previewImage.src = '';
            capturedImageBlob = null;
        });
    }
})();

// ========================================
// KONDISI & VALIDASI
// ========================================
function checkForDamage() {
    let hasDamage = false;

    document.querySelectorAll('.kondisi-select').forEach(select => {
        const card = select.closest('.alat-card');

        // Skip jika form tidak aktif (checkbox tidak dicentang)
        if (card.querySelector('.detail-form-wrapper').style.display === 'none') {
            return;
        }

        const kondisiPinjam = card.dataset.kondisiPinjam;
        const kondisiKembali = select.value;
        const warning = card.querySelector('.warning-kondisi');

        if (kondisiKembali && kondisiKembali !== kondisiPinjam && kondisiKembali !== 'baik') {
            hasDamage = true;
            if (warning) warning.classList.remove('hidden');
            card.classList.add('border-yellow-500');
        } else {
            if (warning) warning.classList.add('hidden');
            card.classList.remove('border-yellow-500');
        }
    });

    const section = document.getElementById('section-surat-pernyataan');
    const suratInput = document.getElementById('dokumen_ba');

    if (hasDamage) {
        section.classList.remove('hidden');
        suratInput.setAttribute('required', 'required');
    } else {
        section.classList.add('hidden');
        suratInput.removeAttribute('required');
        suratInput.value = '';
        const fileInfo = document.getElementById('file-info');
        if (fileInfo) fileInfo.classList.add('hidden');
    }
}

// Trigger check saat kondisi berubah
document.querySelectorAll('.kondisi-select').forEach(select => {
    select.addEventListener('change', checkForDamage);
});

// ========================================
// FORM VALIDATION
// ========================================
document.getElementById('formPengembalian')?.addEventListener('submit', function (e) {
    // 1. Check apakah ada alat yang dipilih
    const selected = document.querySelectorAll('.item-checkbox:checked');
    if (selected.length === 0) {
        e.preventDefault();
        alert('❌ Silakan pilih minimal satu alat untuk dikembalikan.');
        return false;
    }

    // 2. Check kondisi yang belum dipilih
    let emptyKondisi = 0;
    let changedCount = 0;

    document.querySelectorAll('.kondisi-select').forEach(select => {
        const wrapper = select.closest('.detail-form-wrapper');

        // Skip jika form tidak aktif
        if (wrapper && wrapper.style.display !== 'none') {
            if (!select.value) {
                emptyKondisi++;
            } else {
                const card = select.closest('.alat-card');
                const kondisiPinjam = card.dataset.kondisiPinjam;
                if (select.value !== kondisiPinjam && select.value !== 'baik') {
                    changedCount++;
                }
            }
        }
    });

    if (emptyKondisi > 0) {
        e.preventDefault();
        alert(`❌ Ada ${emptyKondisi} alat yang kondisinya belum dipilih!`);
        return false;
    }

    // 3. Check foto pengembalian
    const fotoInput = document.getElementById('foto_pengembalian');
    if (!fotoInput.files || fotoInput.files.length === 0) {
        e.preventDefault();
        alert('❌ Foto pengembalian wajib diupload!');
        fotoInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return false;
    }

    // 4. Check surat pernyataan jika ada kerusakan
    const section = document.getElementById('section-surat-pernyataan');
    const suratInput = document.getElementById('dokumen_ba');

    if (!section.classList.contains('hidden') && (!suratInput.files || suratInput.files.length === 0)) {
        e.preventDefault();
        alert('❌ Berita Acara Kerusakan WAJIB diupload karena ada alat yang rusak!');
        suratInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return false;
    }

    // 5. Konfirmasi jika ada perubahan kondisi
    if (changedCount > 0) {
        if (!confirm(`⚠️ PERINGATAN!\n\nTerdapat ${changedCount} alat yang kondisinya berbeda dari saat dipinjam.\nPastikan Anda sudah mengisi keterangan dan upload berita acara.\n\nLanjutkan pengembalian?`)) {
            e.preventDefault();
            return false;
        }
    }

    // 6. Konfirmasi final
    const totalFoto = fotoInput.files.length;
    const message = `✅ KONFIRMASI PENGEMBALIAN\n\n` +
                   `• ${selected.length} jenis alat akan dikembalikan\n` +
                   `• ${totalFoto} foto pengembalian\n` +
                   (changedCount > 0 ? `• ${changedCount} alat dengan kondisi berbeda\n` : '') +
                   `\nPastikan semua data sudah benar.\nLanjutkan?`;

    if (!confirm(message)) {
        e.preventDefault();
        return false;
    }

    // 7. Show loading indicator
    const submitBtn = document.getElementById('btnSubmit');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split animate-spin"></i> Memproses...';
    }
});

// ========================================
// GENERATE BERITA ACARA
// ========================================
document.getElementById('btnGenerateBA')?.addEventListener('click', function () {
    const kronologi = document.getElementById('kronologi_kerusakan')?.value.trim();

    // Validasi kronologi
    if (!kronologi || kronologi.length < 20) {
        alert('❌ Kronologi kerusakan wajib diisi (minimal 20 karakter).');
        document.getElementById('kronologi_kerusakan').focus();
        return;
    }

    // Kumpulkan data alat rusak
    const alatRusak = [];
    document.querySelectorAll('.kondisi-select').forEach(select => {
        const wrapper = select.closest('.detail-form-wrapper');

        // Skip jika form tidak aktif
        if (wrapper && wrapper.style.display !== 'none') {
            const card = select.closest('.alat-card');
            const kondisiPinjam = card.dataset.kondisiPinjam;
            const kondisiKembali = select.value;

            if (kondisiKembali && kondisiKembali !== kondisiPinjam && kondisiKembali !== 'baik') {
                const detailId = select.dataset.detailId;
                const keterangan = card.querySelector(`textarea[name="detail[${detailId}][keterangan]"]`)?.value || '';

                alatRusak.push({
                    detail_id: detailId,
                    kondisi_awal: kondisiPinjam,
                    kondisi_akhir: kondisiKembali,
                    keterangan: keterangan
                });
            }
        }
    });

    if (alatRusak.length === 0) {
        alert('❌ Tidak ada alat yang rusak!\nSilakan pilih kondisi yang berbeda terlebih dahulu.');
        return;
    }

    if (!confirm(`📄 Generate Berita Acara\n\nAkan dibuat berita acara untuk ${alatRusak.length} alat yang rusak.\n\nLanjutkan?`)) {
        return;
    }

    // Create hidden form untuk submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/pengembalian/{{ $peminjaman->id }}/generate-berita-acara`;
    form.target = '_blank';

    const inputs = [
        { name: '_token', value: '{{ csrf_token() }}' },
        { name: 'kronologi', value: kronologi },
        { name: 'alat_rusak', value: JSON.stringify(alatRusak) }
    ];

    inputs.forEach(i => {
        const inp = document.createElement('input');
        inp.type = 'hidden';
        inp.name = i.name;
        inp.value = i.value;
        form.appendChild(inp);
    });

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);

    // Show success message
    setTimeout(() => {
        alert('✅ Berita Acara sedang di-generate!\n\nPDF akan ter-download otomatis dalam tab baru.\nSetelah itu:\n1. Cetak dokumen\n2. Tandatangani\n3. Scan/foto\n4. Upload di form');
    }, 500);
});

// ========================================
// FILE INFO DISPLAY (Optional Enhancement)
// ========================================
const suratInput = document.getElementById('dokumen_ba');
if (suratInput) {
    suratInput.addEventListener('change', function() {
        const fileInfo = document.getElementById('file-info');
        const fileName = document.getElementById('file-name');

        if (this.files && this.files.length > 0) {
            const files = Array.from(this.files);
            const names = files.map(f => f.name).join(', ');

            if (fileName) fileName.textContent = names;
            if (fileInfo) fileInfo.classList.remove('hidden');
        } else {
            if (fileInfo) fileInfo.classList.add('hidden');
        }
    });
}
</script>
@endpush
