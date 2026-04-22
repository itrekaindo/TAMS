@extends('layouts.app')

@section('title', 'Edit Peminjam')
@section('page-title', 'Edit Peminjam')
@section('page-subtitle', 'Ubah data peminjam yang sudah terdaftar')

@section('content')
    <div class="space-y-6">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm">
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-blue-600 transition-colors font-medium">
                <i class="bi bi-house-door"></i>
                Dashboard
            </a>
            <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
            <a href="{{ route('peminjam.index') }}" class="text-gray-500 hover:text-blue-600 transition-colors font-medium">
                Data Peminjam
            </a>
            <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
            <span class="text-gray-900 font-semibold">Edit Peminjam</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Form Card --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    {{-- Header --}}
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-6 py-5 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-1.5 h-8 bg-gradient-to-b from-amber-500 to-orange-500 rounded-full"></div>
                            <div>
                                <h2 class="text-xl font-black text-gray-900">Form Edit Peminjam</h2>
                                <p class="text-sm text-gray-500 font-medium">Perbarui informasi data peminjam di bawah ini</p>
                            </div>
                        </div>
                    </div>

                    {{-- Form --}}
                    <form action="{{ route('peminjam.update', $peminjam->id) }}" method="POST" class="p-6 space-y-5">
                        @csrf
                        @method('PATCH')

                        {{-- Nama Lengkap --}}
                        <div>
                            <label for="nama_lengkap" class="block text-sm font-bold text-gray-700 mb-1.5">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i class="bi bi-person-fill text-gray-400"></i>
                                </div>
                                <input type="text" id="nama_lengkap" name="nama_lengkap"
                                    value="{{ old('nama_lengkap', $peminjam->nama_lengkap) }}"
                                    class="w-full pl-10 pr-4 py-2.5 border-2 rounded-xl text-sm font-medium transition-all
                                        {{ $errors->has('nama_lengkap') ? 'border-red-400 focus:border-red-500 focus:ring-red-500/20' : 'border-gray-200 focus:border-amber-500 focus:ring-amber-500/20' }}
                                        focus:outline-none focus:ring-4"
                                    placeholder="Masukkan nama lengkap">
                            </div>
                            @error('nama_lengkap')
                                <p class="mt-1.5 text-xs font-semibold text-red-500 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- NIP --}}
                        <div>
                            <label for="nip" class="block text-sm font-bold text-gray-700 mb-1.5">
                                NIP <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i class="bi bi-person-badge-fill text-gray-400"></i>
                                </div>
                                <input type="text" id="nip" name="nip"
                                    value="{{ old('nip', $peminjam->nip) }}"
                                    class="w-full pl-10 pr-4 py-2.5 border-2 rounded-xl text-sm font-medium font-mono transition-all
                                        {{ $errors->has('nip') ? 'border-red-400 focus:border-red-500 focus:ring-red-500/20' : 'border-gray-200 focus:border-amber-500 focus:ring-amber-500/20' }}
                                        focus:outline-none focus:ring-4"
                                    placeholder="Masukkan NIP">
                            </div>
                            @error('nip')
                                <p class="mt-1.5 text-xs font-semibold text-red-500 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Departemen --}}
                        <div>
                            <label for="departemen" class="block text-sm font-bold text-gray-700 mb-1.5">
                                Departemen <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i class="bi bi-building-fill text-gray-400"></i>
                                </div>
                                <input type="text" id="departemen" name="departemen"
                                    value="{{ old('departemen', $peminjam->departemen) }}"
                                    class="w-full pl-10 pr-4 py-2.5 border-2 rounded-xl text-sm font-medium transition-all
                                        {{ $errors->has('departemen') ? 'border-red-400 focus:border-red-500 focus:ring-red-500/20' : 'border-gray-200 focus:border-amber-500 focus:ring-amber-500/20' }}
                                        focus:outline-none focus:ring-4"
                                    placeholder="Masukkan nama departemen">
                            </div>
                            @error('departemen')
                                <p class="mt-1.5 text-xs font-semibold text-red-500 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-1.5">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i class="bi bi-envelope-fill text-gray-400"></i>
                                </div>
                                <input type="email" id="email" name="email"
                                    value="{{ old('email', $peminjam->email) }}"
                                    class="w-full pl-10 pr-4 py-2.5 border-2 rounded-xl text-sm font-medium transition-all
                                        {{ $errors->has('email') ? 'border-red-400 focus:border-red-500 focus:ring-red-500/20' : 'border-gray-200 focus:border-amber-500 focus:ring-amber-500/20' }}
                                        focus:outline-none focus:ring-4"
                                    placeholder="contoh@email.com">
                            </div>
                            @error('email')
                                <p class="mt-1.5 text-xs font-semibold text-red-500 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Telepon --}}
                        <div>
                            <label for="telepon" class="block text-sm font-bold text-gray-700 mb-1.5">
                                Telepon <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i class="bi bi-telephone-fill text-gray-400"></i>
                                </div>
                                <input type="text" id="telepon" name="telepon"
                                    value="{{ old('telepon', $peminjam->telepon) }}"
                                    class="w-full pl-10 pr-4 py-2.5 border-2 rounded-xl text-sm font-medium transition-all
                                        {{ $errors->has('telepon') ? 'border-red-400 focus:border-red-500 focus:ring-red-500/20' : 'border-gray-200 focus:border-amber-500 focus:ring-amber-500/20' }}
                                        focus:outline-none focus:ring-4"
                                    placeholder="08xxxxxxxxxx">
                            </div>
                            @error('telepon')
                                <p class="mt-1.5 text-xs font-semibold text-red-500 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
                            <a href="{{ route('peminjam.index') }}"
                                class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-gray-200 text-gray-600 font-bold text-sm rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all">
                                <i class="bi bi-x-circle"></i>
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-amber-400 to-orange-400 hover:from-amber-500 hover:to-orange-500 text-white font-bold text-sm rounded-xl shadow-md hover:shadow-lg hover:shadow-orange-500/30 transition-all duration-300">
                                <i class="bi bi-check-circle-fill"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Info Sidebar --}}
            <div class="space-y-5">

                {{-- Info Peminjam --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-5 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-black text-gray-700 uppercase tracking-wider">Info Peminjam</h3>
                    </div>
                    <div class="p-5 space-y-4">
                        {{-- Avatar --}}
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-2xl shadow-lg flex-shrink-0">
                                {{ strtoupper(substr($peminjam->nama_lengkap, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-black text-gray-900 text-base">{{ $peminjam->nama_lengkap }}</p>
                                <p class="text-xs text-gray-500 font-medium">{{ $peminjam->departemen }}</p>
                            </div>
                        </div>

                        <div class="space-y-2.5 pt-1">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500 font-medium">Total Peminjaman</span>
                                <span class="font-black text-gray-900">{{ $peminjam->peminjamans()->count() }} kali</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500 font-medium">Peminjaman Aktif</span>
                                @php $aktif = $peminjam->peminjamans()->where('status', 'dipinjam')->count(); @endphp
                                <span class="font-black {{ $aktif > 0 ? 'text-orange-500' : 'text-green-500' }}">
                                    {{ $aktif }} aktif
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500 font-medium">Terdaftar Sejak</span>
                                <span class="font-bold text-gray-700">{{ $peminjam->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Peringatan jika ada peminjaman aktif --}}
                @if($aktif > 0)
                    <div class="bg-gradient-to-br from-yellow-50 to-orange-50 border border-yellow-200 rounded-2xl p-5">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="bi bi-exclamation-triangle-fill text-yellow-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-black text-yellow-800 mb-1">Peminjaman Sedang Berjalan</p>
                                <p class="text-xs text-yellow-700 font-medium leading-relaxed">
                                    Peminjam ini masih memiliki <strong>{{ $aktif }} peminjaman aktif</strong>. Perubahan data akan tetap berlaku.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Link ke detail --}}
                {{-- <a href="{{ route('peminjam.show', $peminjam->id) }}"
                    class="flex items-center justify-between w-full px-5 py-3.5 bg-white border-2 border-gray-200 hover:border-blue-400 hover:bg-blue-50 rounded-2xl transition-all group">
                    <span class="text-sm font-bold text-gray-700 group-hover:text-blue-600">Lihat Detail Peminjam</span>
                    <i class="bi bi-arrow-right text-gray-400 group-hover:text-blue-500 group-hover:translate-x-1 transition-all"></i>
                </a> --}}
            </div>
        </div>
    </div>
@endsection
