@extends('layouts.app')

@section('title', 'Tambah Alat Baru')
@section('page-title', 'Tambah Alat')
@section('page-subtitle', 'Daftarkan alat baru ke dalam sistem')

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
        <span class="text-gray-900 font-semibold">Tambah Alat</span>
    </nav>

    {{-- Main Form Card --}}
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-700 p-8">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center shadow-xl">
                        <i class="bi bi-plus-circle text-white text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-black text-white mb-1">Form Tambah Alat</h2>
                        <p class="text-blue-100 font-medium">Lengkapi informasi alat yang akan didaftarkan</p>
                    </div>
                </div>
            </div>

            {{-- Form Content --}}
            <div class="p-8">
                <form action="{{ route('alat.store') }}" method="POST" id="alatForm">
                    @csrf

                    {{-- Section: Identitas Alat --}}
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="bi bi-card-heading text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-gray-900">Identitas Alat</h3>
                                <p class="text-sm text-gray-500 font-medium">Informasi dasar alat</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Kode Alat --}}
                            <div>
                                <label for="kode_alat" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                                    <i class="bi bi-upc-scan text-blue-600"></i>
                                    Kode Alat
                                    <span class="text-red-600">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        type="text"
                                        id="kode_alat"
                                        name="kode_alat"
                                        value="{{ old('kode_alat') }}"
                                        placeholder="Contoh: CTLHT24301"
                                        required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all font-mono text-sm @error('kode_alat') border-red-500 @enderror"
                                    >
                                    @error('kode_alat')
                                        <div class="absolute -bottom-6 left-0 flex items-center gap-1 text-xs text-red-600">
                                            <i class="bi bi-exclamation-circle-fill"></i>
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                                <p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                                    <i class="bi bi-info-circle"></i>
                                    Kode unik untuk identifikasi alat
                                </p>
                            </div>

                            {{-- Nama Alat --}}
                            <div>
                                <label for="nama_alat" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                                    <i class="bi bi-box-seam text-blue-600"></i>
                                    Nama Alat
                                    <span class="text-red-600">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        type="text"
                                        id="nama_alat"
                                        name="nama_alat"
                                        value="{{ old('nama_alat') }}"
                                        placeholder="Contoh: Crimping Ferrules"
                                        required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all @error('nama_alat') border-red-500 @enderror"
                                    >
                                    @error('nama_alat')
                                        <div class="absolute -bottom-6 left-0 flex items-center gap-1 text-xs text-red-600">
                                            <i class="bi bi-exclamation-circle-fill"></i>
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mt-8">
                            <label for="deskripsi" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                                <i class="bi bi-file-text text-blue-600"></i>
                                Deskripsi
                            </label>
                            <textarea
                                id="deskripsi"
                                name="deskripsi"
                                rows="4"
                                placeholder="Jelaskan spesifikasi atau keterangan detail tentang alat ini..."
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all resize-none @error('deskripsi') border-red-500 @enderror"
                            >{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 flex items-center gap-1 text-xs text-red-600">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                                <i class="bi bi-info-circle"></i>
                                Spesifikasi atau keterangan detail alat
                            </p>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="my-8 border-t-2 border-gray-100"></div>

                    {{-- Section: Klasifikasi --}}
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="bi bi-tag text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-gray-900">Klasifikasi</h3>
                                <p class="text-sm text-gray-500 font-medium">Kategori dan lokasi penyimpanan</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Kategori --}}
                            <div>
                                <label for="kategori" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                                    <i class="bi bi-grid text-purple-600"></i>
                                    Kategori
                                </label>
                                <input
                                    type="text"
                                    id="kategori"
                                    name="kategori"
                                    value="{{ old('kategori') }}"
                                    placeholder="Contoh: Hand Tools, Special Tools dll."
                                    list="kategori-list"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-all @error('kategori') border-red-500 @enderror"
                                >
                                {{-- <datalist id="kategori-list">
                                    <option value="Elektronik">
                                    <option value="Alat Tulis">
                                    <option value="Furniture">
                                    <option value="Peralatan Laboratorium">
                                    <option value="Alat Olahraga">
                                    <option value="Peralatan Kantor">
                                    <option value="Alat Multimedia">
                                </datalist> --}}
                                @error('kategori')
                                    <p class="mt-1 flex items-center gap-1 text-xs text-red-600">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                                    <i class="bi bi-lightbulb"></i>
                                    Ketik untuk melihat saran kategori
                                </p>
                            </div>

                            {{-- Lokasi --}}
                            <div>
                                <label for="lokasi" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                                    <i class="bi bi-geo-alt text-purple-600"></i>
                                    Lokasi Penyimpanan
                                </label>
                                <input
                                    type="text"
                                    id="lokasi"
                                    name="lokasi"
                                    value="{{ old('lokasi') }}"
                                    placeholder="Contoh: Gudang A - Rak 3"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-all @error('lokasi') border-red-500 @enderror"
                                >
                                @error('lokasi')
                                    <p class="mt-1 flex items-center gap-1 text-xs text-red-600">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="my-8 border-t-2 border-gray-100"></div>

                    {{-- Section: Spesifikasi & Identitas --}}
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-cyan-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="bi bi-sliders text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-gray-900">Spesifikasi Alat</h3>
                                <p class="text-sm text-gray-500 font-medium">Detail teknis dan identitas tambahan</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {{-- Spesifikasi Type --}}
                            <div>
                                <label for="spesifikasi_type" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                                    <i class="bi bi-gear-wide-connected text-cyan-600"></i>
                                    Tipe Spesifikasi
                                </label>
                                <input
                                    type="text"
                                    id="spesifikasi_type"
                                    name="spesifikasi_type"
                                    value="{{ old('spesifikasi_type') }}"
                                    placeholder="Contoh: NF-8209S, XT-2000"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all @error('spesifikasi_type') border-red-500 @enderror"
                                >
                                @error('spesifikasi_type')
                                    <p class="mt-1 flex items-center gap-1 text-xs text-red-600">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Merk --}}
                            <div>
                                <label for="merk" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                                    <i class="bi bi-badge-tm text-cyan-600"></i>
                                    Merk
                                </label>
                                <input
                                    type="text"
                                    id="merk"
                                    name="merk"
                                    value="{{ old('merk') }}"
                                    placeholder="Contoh: MELZER, K-8, BOSCH"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all @error('merk') border-red-500 @enderror"
                                >
                                @error('merk')
                                    <p class="mt-1 flex items-center gap-1 text-xs text-red-600">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Kapasitas --}}
                            <div>
                                <label for="kapasitas" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                                    <i class="bi bi-droplet text-cyan-600"></i>
                                    Kapasitas
                                </label>
                                <input
                                    type="text"
                                    id="kapasitas"
                                    name="kapasitas"
                                    value="{{ old('kapasitas') }}"
                                    placeholder="Contoh: 4mm - 10mm"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all @error('kapasitas') border-red-500 @enderror"
                                >
                                @error('kapasitas')
                                    <p class="mt-1 flex items-center gap-1 text-xs text-red-600">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="my-8 border-t-2 border-gray-100"></div>

                    {{-- Section: Penugasan & Kategorisasi --}}
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="bi bi-person-badge text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-gray-900">Penugasan & Kategori</h3>
                                <p class="text-sm text-gray-500 font-medium">Informasi penugasan dan klasifikasi lanjutan</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Jenis Tools --}}
                            <div>
                                <label for="jenis_tools" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                                    <i class="bi bi-wrench text-amber-600"></i>
                                    Jenis Tools
                                </label>
                                <select
                                    id="jenis_tools"
                                    name="jenis_tools"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition-all @error('jenis_tools') border-red-500 @enderror"
                                >
                                    <option value="">-- Pilih Jenis Tools --</option>
                                    @foreach(\App\Models\Alat::jenisToolsOptions() as $key => $value)
                                        <option value="{{ $key }}" {{ old('jenis_tools') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenis_tools')
                                    <p class="mt-1 flex items-center gap-1 text-xs text-red-600">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Kategori Tools --}}
                            <div>
                                <label for="kategori_tools" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                                    <i class="bi bi-layers text-amber-600"></i>
                                    Kategori Tools
                                </label>
                                <select
                                    id="kategori_tools"
                                    name="kategori_tools"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition-all @error('kategori_tools') border-red-500 @enderror"
                                >
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach(\App\Models\Alat::kategoriToolsOptions() as $key => $value)
                                        <option value="{{ $key }}" {{ old('kategori_tools') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_tools')
                                    <p class="mt-1 flex items-center gap-1 text-xs text-red-600">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Proyek --}}
                            <div>
                                <label for="proyek" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                                    <i class="bi bi-building text-amber-600"></i>
                                    Proyek
                                </label>
                                <select
                                    id="proyek"
                                    name="proyek"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition-all @error('proyek') border-red-500 @enderror"
                                >
                                    <option value="">-- Pilih Proyek --</option>
                                    @foreach(\App\Models\Alat::proyekOptions() as $key => $value)
                                        <option value="{{ $key }}" {{ old('proyek') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('proyek')
                                    <p class="mt-1 flex items-center gap-1 text-xs text-red-600">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- PIC (Penanggung Jawab) --}}
                            <div>
                                <label for="pic" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                                    <i class="bi bi-person-circle text-amber-600"></i>
                                    PIC (Penanggung Jawab)
                                </label>
                                <input
                                    type="text"
                                    id="pic"
                                    name="pic"
                                    value="{{ old('pic') }}"
                                    placeholder="Nama atau NIP PIC"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition-all @error('pic') border-red-500 @enderror"
                                >
                                @error('pic')
                                    <p class="mt-1 flex items-center gap-1 text-xs text-red-600">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Pemakai --}}
                            <div>
                                <label for="pemakai" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                                    <i class="bi bi-person text-amber-600"></i>
                                    Pemakai
                                </label>
                                <input
                                    type="text"
                                    id="pemakai"
                                    name="pemakai"
                                    value="{{ old('pemakai') }}"
                                    placeholder="Nama pengguna alat"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition-all @error('pemakai') border-red-500 @enderror"
                                >
                                @error('pemakai')
                                    <p class="mt-1 flex items-center gap-1 text-xs text-red-600">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Lokasi Distribusi --}}
                            <div>
                                <label for="lokasi_distribusi" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                                    <i class="bi bi-geo-alt text-amber-600"></i>
                                    Lokasi Distribusi
                                </label>
                                <input
                                    type="text"
                                    id="lokasi_distribusi"
                                    name="lokasi_distribusi"
                                    value="{{ old('lokasi_distribusi') }}"
                                    placeholder="Lokasi penempatan alat"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition-all @error('lokasi_distribusi') border-red-500 @enderror"
                                >
                                @error('lokasi_distribusi')
                                    <p class="mt-1 flex items-center gap-1 text-xs text-red-600">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Sticker --}}
                            <div class="lg:col-span-2">
                                <div class="flex items-start gap-3 pt-2">
                                    <input
                                        type="checkbox"
                                        id="sticker"
                                        name="sticker"
                                        value="1"
                                        {{ old('sticker') ? 'checked' : '' }}
                                        class="mt-1 w-5 h-5 text-amber-600 rounded focus:ring-amber-500 focus:ring-2"
                                    >
                                    <div>
                                        <label for="sticker" class="text-sm font-bold text-gray-700">
                                            <i class="bi bi-tag text-amber-600"></i>
                                            Alat ini memiliki sticker identifikasi
                                        </label>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Centang jika alat telah diberi sticker identifikasi
                                        </p>
                                    </div>
                                </div>
                                @error('sticker')
                                    <p class="mt-1 flex items-center gap-1 text-xs text-red-600">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Foto Tools
                            <div>
                                <label for="foto_tools" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                                    <i class="bi bi-camera text-amber-600"></i>
                                    Foto Tools (URL/path)
                                </label>
                                <input
                                    type="text"
                                    id="foto_tools"
                                    name="foto_tools"
                                    value="{{ old('foto_tools') }}"
                                    placeholder="Opsional: path file atau URL"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition-all @error('foto_tools') border-red-500 @enderror"
                                >
                                @error('foto_tools')
                                    <p class="mt-1 flex items-center gap-1 text-xs text-red-600">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div> --}}

                            {{-- Hilang --}}
                            <div class="lg:col-span-2">
                                <div class="flex items-start gap-3 pt-2">
                                    <input
                                        type="checkbox"
                                        id="hilang"
                                        name="hilang"
                                        value="1"
                                        {{ old('hilang') ? 'checked' : '' }}
                                        class="mt-1 w-5 h-5 text-red-600 rounded focus:ring-red-500 focus:ring-2"
                                    >
                                    <div>
                                        <label for="hilang" class="text-sm font-bold text-gray-700">
                                            <i class="bi bi-exclamation-triangle text-red-600"></i>
                                            Alat ini dilaporkan hilang
                                        </label>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Centang jika alat ini tidak dapat ditemukan
                                        </p>
                                    </div>
                                </div>
                                @error('hilang')
                                    <p class="mt-1 flex items-center gap-1 text-xs text-red-600">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="my-8 border-t-2 border-gray-100"></div>

                    {{-- Section: Informasi Stok --}}
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="bi bi-boxes text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-gray-900">Informasi Stok</h3>
                                <p class="text-sm text-gray-500 font-medium">Jumlah dan kondisi alat</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Jumlah Total --}}
                            <div>
                                <label for="jumlah_total" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                                    <i class="bi bi-calculator text-green-600"></i>
                                    Jumlah Total
                                    <span class="text-red-600">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        type="number"
                                        id="jumlah_total"
                                        name="jumlah_total"
                                        value="{{ old('jumlah_total', 1) }}"
                                        min="1"
                                        required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all @error('jumlah_total') border-red-500 @enderror"
                                    >
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 text-sm font-bold text-gray-400">
                                        unit
                                    </div>
                                    @error('jumlah_total')
                                        <div class="absolute -bottom-6 left-0 flex items-center gap-1 text-xs text-red-600">
                                            <i class="bi bi-exclamation-circle-fill"></i>
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                                <p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                                    <i class="bi bi-info-circle"></i>
                                    Total unit yang dimiliki
                                </p>
                            </div>

                            {{-- Kondisi --}}
                            <div>
                                <label for="kondisi" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                                    <i class="bi bi-tools text-green-600"></i>
                                    Kondisi Alat
                                    <span class="text-red-600">*</span>
                                </label>
                                <select
                                    id="kondisi"
                                    name="kondisi"
                                    required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all @error('kondisi') border-red-500 @enderror"
                                >
                                    <option value="">-- Pilih Kondisi --</option>
                                    @foreach(\App\Models\Alat::kondisiOptions() as $key => $value)
                                        <option value="{{ $key }}" {{ old('kondisi') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kondisi')
                                    <p class="mt-1 flex items-center gap-1 text-xs text-red-600">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Info Box --}}
                    <div class="mb-8 p-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-2xl">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center">
                                <i class="bi bi-info-circle text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="font-bold text-blue-900 mb-1">Informasi Penting</p>
                                <p class="text-sm text-blue-800 leading-relaxed">
                                    Jumlah tersedia akan otomatis sama dengan jumlah total saat pertama kali ditambahkan.
                                    Jumlah ini akan berkurang secara otomatis ketika alat dipinjam.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-wrap gap-4 pt-6 border-t-2 border-gray-100">
                        <button
                            type="submit"
                            class="group inline-flex items-center gap-2 px-8 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg hover:shadow-blue-500/50 transition-all font-bold hover:-translate-y-0.5">
                            <i class="bi bi-save text-xl"></i>
                            <span>Simpan Alat</span>
                            <i class="bi bi-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                        </button>

                        <a
                            href="{{ route('alat.index') }}"
                            class="inline-flex items-center gap-2 px-8 py-3.5 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 rounded-xl hover:shadow-lg transition-all font-bold hover:-translate-y-0.5">
                            <i class="bi bi-x-circle text-xl"></i>
                            <span>Batal</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-generate kode alat suggestion
    document.getElementById('kategori')?.addEventListener('input', function() {
        const kategori = this.value;
        const kodeInput = document.getElementById('kode_alat');

        if (kategori && !kodeInput.value) {
            const prefix = kategori.substring(0, 3).toUpperCase();
            const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
            kodeInput.placeholder = `Saran: ${prefix}${random}`;
        }
    });

    // Input validation styling
    const inputs = document.querySelectorAll('input[required], select[required], textarea[required]');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.classList.add('border-red-300');
                this.classList.remove('border-gray-200');
            } else {
                this.classList.remove('border-red-300');
                this.classList.add('border-green-300');
            }
        });

        input.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                this.classList.remove('border-red-300');
                this.classList.add('border-gray-200');
            }
        });
    });

    // Form submit confirmation
    document.getElementById('alatForm')?.addEventListener('submit', function(e) {
        const button = this.querySelector('button[type="submit"]');
        button.disabled = true;
        button.innerHTML = '<i class="bi bi-hourglass-split animate-spin"></i> <span>Menyimpan...</span>';
    });
</script>
@endsection
