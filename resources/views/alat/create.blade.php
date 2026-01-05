{{-- resources/views/alat/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Alat')
@section('page-title', 'Tambah Alat Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <i class="bi bi-plus-circle text-blue-600"></i> Form Tambah Alat
            </h2>
        </div>

        <div class="p-6">
            <form action="{{ route('alat.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Kode Alat -->
                    <div>
                        <label for="kode_alat" class="block text-sm font-medium text-gray-700 mb-1">
                            Kode Alat <span class="text-red-600">*</span>
                        </label>
                        <input
                            type="text"
                            id="kode_alat"
                            name="kode_alat"
                            value="{{ old('kode_alat') }}"
                            placeholder="Contoh: LTP001"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                        >
                        @error('kode_alat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Kode unik untuk identifikasi alat</p>
                    </div>

                    <!-- Nama Alat -->
                    <div>
                        <label for="nama_alat" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Alat <span class="text-red-600">*</span>
                        </label>
                        <input
                            type="text"
                            id="nama_alat"
                            name="nama_alat"
                            value="{{ old('nama_alat') }}"
                            placeholder="Contoh: Laptop Asus ROG"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                        >
                        @error('nama_alat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">
                        Deskripsi
                    </label>
                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        rows="3"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                    >{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Spesifikasi atau keterangan detail alat</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Kategori -->
                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">
                            Kategori
                        </label>
                        <input
                            type="text"
                            id="kategori"
                            name="kategori"
                            value="{{ old('kategori') }}"
                            placeholder="Contoh: Elektronik"
                            list="kategori-list"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                        >
                        <datalist id="kategori-list">
                            <option value="Elektronik">
                            <option value="Alat Tulis">
                            <option value="Furniture">
                            <option value="Peralatan Laboratorium">
                            <option value="Alat Olahraga">
                        </datalist>
                        @error('kategori')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lokasi -->
                    <div>
                        <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">
                            Lokasi
                        </label>
                        <input
                            type="text"
                            id="lokasi"
                            name="lokasi"
                            value="{{ old('lokasi') }}"
                            placeholder="Contoh: Gudang A"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                        >
                        @error('lokasi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Jumlah Total -->
                    <div>
                        <label for="jumlah_total" class="block text-sm font-medium text-gray-700 mb-1">
                            Jumlah Total <span class="text-red-600">*</span>
                        </label>
                        <input
                            type="number"
                            id="jumlah_total"
                            name="jumlah_total"
                            value="{{ old('jumlah_total', 1) }}"
                            min="1"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                        >
                        @error('jumlah_total')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Total unit yang dimiliki</p>
                    </div>

                    <!-- Kondisi -->
                    <div>
                        <label for="kondisi" class="block text-sm font-medium text-gray-700 mb-1">
                            Kondisi <span class="text-red-600">*</span>
                        </label>
                        <select
                            id="kondisi"
                            name="kondisi"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                        >
                            <option value="">-- Pilih Kondisi --</option>
                            @foreach(\App\Models\Alat::kondisiOptions() as $key => $value)
                                <option value="{{ $key }}" {{ old('kondisi') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('kondisi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Info Box -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex">
                        <i class="bi bi-info-circle text-blue-600 text-lg mt-0.5 mr-2"></i>
                        <p class="text-sm text-blue-800">
                            <strong>Catatan:</strong> Jumlah tersedia akan otomatis sama dengan jumlah total saat pertama kali ditambahkan.
                        </p>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-wrap gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('alat.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
