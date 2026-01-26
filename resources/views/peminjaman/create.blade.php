@extends('layouts.public')

@section('title', 'Form Peminjaman Alat')

@section('content')
    <div class="max-w-5xl mx-auto">
        {{-- Header Card --}}
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-8 py-6">
                <div class="flex items-center gap-4">
                    <div
                        class="w-14 h-14 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center shadow-xl">
                        <i class="bi bi-plus-circle text-white text-3xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-black text-white">Form Peminjaman Alat</h1>
                        <p class="text-blue-100 text-sm font-medium mt-1">Lengkapi formulir di bawah ini untuk meminjam alat
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data" id="formPeminjaman"
                class="p-8 space-y-8">
                @csrf

                {{-- Data Peminjam Section --}}
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="bi bi-person-fill text-white text-xl"></i>
                        </div>
                        <h2 class="text-xl font-black text-gray-900">Data Peminjam</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nama Lengkap --}}
                        <div>
                            <label for="nama_lengkap" class="block text-sm font-bold text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('nama_lengkap') border-red-500 @enderror"
                                id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                placeholder="Masukkan nama lengkap" required>
                            @error('nama_lengkap')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- NIP --}}
                        <div>
                            <label for="nip" class="block text-sm font-bold text-gray-700 mb-2">
                                NIP <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('nip') border-red-500 @enderror"
                                id="nip" name="nip" value="{{ old('nip') }}" placeholder="Masukkan NIP"
                                required>
                            @error('nip')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Departemen --}}
                        <div>
                            <label for="departemen" class="block text-sm font-bold text-gray-700 mb-2">
                                Departemen/Bagian <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('departemen') border-red-500 @enderror"
                                id="departemen" name="departemen" value="{{ old('departemen') }}"
                                placeholder="Contoh: IT Support, Teknik, Administrasi" required>
                            @error('departemen')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('email') border-red-500 @enderror"
                                id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email"
                                required>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Telepon --}}
                        <div class="md:col-span-2">
                            <label for="telepon" class="block text-sm font-bold text-gray-700 mb-2">
                                Nomor Telepon <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('telepon') border-red-500 @enderror"
                                id="telepon" name="telepon" value="{{ old('telepon') }}"
                                placeholder="Contoh: 081234567890" required>
                            @error('telepon')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Data Alat Section --}}
                <div class="border-t-2 border-gray-100"></div>
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="bi bi-box-seam text-white text-xl"></i>
                            </div>
                            <h2 class="text-xl font-black text-gray-900">Data Alat yang Dipinjam</h2>
                        </div>
                        <button type="button" id="btnTambahAlat"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-green-500/50 transition-all">
                            <i class="bi bi-plus-circle text-lg"></i>
                            Tambah Alat
                        </button>
                    </div>

                    {{-- Container Alat --}}
                    <div id="containerAlat" class="space-y-4">
                        {{-- Item Alat Pertama --}}
                        <div class="alat-item bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl p-6 border-2 border-gray-200"
                            data-index="0">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-black text-gray-900">
                                    Alat #<span class="item-number">1</span>
                                </h3>
                                <button type="button"
                                    class="btn-hapus-alat inline-flex items-center gap-2 px-3 py-2 bg-red-500 text-white rounded-lg font-bold text-sm hover:bg-red-600 transition-all"
                                    style="display: none;">
                                    <i class="bi bi-trash"></i>
                                    Hapus
                                </button>
                            </div>

                            <div class="space-y-4">
                                {{-- Pilih Alat --}}
                                {{-- <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        Pilih Alat <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        class="select-alat w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('alat.0.alat_id') border-red-500 @enderror"
                                        name="alat[0][alat_id]" required>
                                        <option value="">-- Pilih Alat yang Akan Dipinjam --</option>
                                        @foreach ($alats as $alat)
                                            <option value="{{ $alat->id }}"
                                                data-kode="{{ $alat->kode_alat }}"
                                                data-nama="{{ $alat->nama_alat }}"
                                                data-tersedia="{{ $alat->jumlah_tersedia }}"
                                                data-kondisi="{{ $alat->kondisi }}"
                                                {{ old('alat.0.alat_id') == $alat->id ? 'selected' : '' }}>
                                                {{ $alat->nama_alat }} ({{ $alat->kode_alat }}) -
                                                Tersedia: {{ $alat->jumlah_tersedia }} -
                                                Kondisi: {{ ucfirst(str_replace('_', ' ', $alat->kondisi)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('alat.0.alat_id')
                                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                            <i class="bi bi-exclamation-circle-fill"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div> --}}
                                {{-- Pilih Alat --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        Pilih Alat <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        class="select-alat w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('alat.0.alat_id') border-red-500 @enderror"
                                        name="alat[0][alat_id]" id="select-alat-0" required>
                                        <option value="">-- Cari dan Pilih Alat --</option>
                                    </select>
                                    @error('alat.0.alat_id')
                                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                            <i class="bi bi-exclamation-circle-fill"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    {{-- Jumlah --}}
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">
                                            Jumlah <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number"
                                            class="input-jumlah w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('alat.0.jumlah') border-red-500 @enderror"
                                            name="alat[0][jumlah]" value="{{ old('alat.0.jumlah', 1) }}" min="1"
                                            required>
                                        <p class="mt-2 text-sm text-gray-500 font-medium">
                                            Tersedia: <span class="jumlah-tersedia text-green-600 font-bold">0</span> unit
                                        </p>
                                        @error('alat.0.jumlah')
                                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                                <i class="bi bi-exclamation-circle-fill"></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    {{-- Kondisi --}}
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">
                                            Kondisi Alat <span class="text-red-500">*</span>
                                        </label>
                                        <select
                                            class="select-kondisi w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-100 @error('alat.0.kondisi_alat') border-red-500 @enderror"
                                            name="alat[0][kondisi_alat]">
                                            <option value="">-- Kondisi Otomatis --</option>
                                            <option value="baik">Baik</option>
                                            <option value="rusak">Rusak</option>
                                        </select>
                                        <p class="mt-2 text-sm text-gray-500">Kondisi diambil otomatis dari database alat
                                        </p>
                                        @error('alat.0.kondisi_alat')
                                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                                <i class="bi bi-exclamation-circle-fill"></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @error('alat')
                        <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                            <p class="text-sm text-red-700 font-semibold">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                {{-- Divider --}}
                <div class="border-t-2 border-gray-100"></div>

                {{-- Detail Peminjaman Section --}}
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="bi bi-calendar-check text-white text-xl"></i>
                        </div>
                        <h2 class="text-xl font-black text-gray-900">Detail Peminjaman</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Tanggal Peminjaman --}}
                        <div>
                            <label for="tanggal_pinjam" class="block text-sm font-bold text-gray-700 mb-2">
                                Tanggal Peminjaman
                            </label>
                            <input type="text"
                                class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-xl text-gray-700 font-semibold cursor-not-allowed"
                                id="tanggal_pinjam" value="{{ now()->isoFormat('D MMMM Y') }}" readonly>
                            <p class="mt-2 text-sm text-gray-500">Diisi otomatis saat peminjaman</p>
                        </div>

                        {{-- Tanggal Rencana Pengembalian --}}
                        <div>
                            <label for="tanggal_kembali_rencana" class="block text-sm font-bold text-gray-700 mb-2">
                                Tanggal Rencana Pengembalian <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('tanggal_kembali_rencana') border-red-500 @enderror"
                                id="tanggal_kembali_rencana" name="tanggal_kembali_rencana"
                                value="{{ old('tanggal_kembali_rencana') }}" min="{{ now()->format('Y-m-d') }}"
                                required>
                            @error('tanggal_kembali_rencana')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Keperluan --}}
                        <div class="md:col-span-2">
                            <label for="keperluan" class="block text-sm font-bold text-gray-700 mb-2">
                                Keperluan <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('keperluan') border-red-500 @enderror"
                                id="keperluan" name="keperluan" rows="4" placeholder="Jelaskan untuk apa alat ini akan digunakan"
                                required>{{ old('keperluan') }}</textarea>
                            @error('keperluan')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Upload Foto --}}
                        <div class="md:col-span-2">
                            <label for="foto_peminjaman" class="block text-sm font-bold text-gray-700 mb-2">
                                Upload Foto <span class="text-red-500">*</span>
                            </label>

                            {{-- Button Group - RESPONSIVE --}}
                            <div class="flex flex-col sm:flex-row gap-3 mb-4">
                                {{-- Desktop Only: Pilih dari File --}}
                                <button type="button" id="btnChooseFile"
                                    class="hidden md:flex flex-1 items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-bold hover:shadow-lg hover:shadow-blue-500/50 transition-all">
                                    <i class="bi bi-image text-lg"></i>
                                    Pilih dari File
                                </button>

                                {{-- Mobile Only: Ambil Foto --}}
                                <button type="button" id="btnOpenCamera"
                                    class="flex md:hidden flex-1 items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl font-bold hover:shadow-lg hover:shadow-green-500/50 transition-all">
                                    <i class="bi bi-camera text-lg"></i>
                                    Ambil Foto
                                </button>
                            </div>

                            {{-- Hidden File Input --}}
                            <input type="file" id="foto_peminjaman" name="foto_peminjaman" accept="image/*"
                                class="hidden" required>

                            <p class="text-sm text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB</p>

                            @error('foto_peminjaman')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                    {{ $message }}
                                </p>
                            @enderror

                            {{-- Camera Modal --}}
                            <div id="cameraModal"
                                class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4">
                                <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full overflow-hidden">
                                    <div
                                        class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4 flex items-center justify-between">
                                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                                            <i class="bi bi-camera-fill"></i>
                                            Ambil Foto
                                        </h3>
                                        <button type="button" id="btnCloseCamera"
                                            class="text-white hover:text-gray-200 transition-all">
                                            <i class="bi bi-x-lg text-2xl"></i>
                                        </button>
                                    </div>

                                    <div class="p-6">
                                        {{-- Camera View --}}
                                        <div id="cameraView" class="relative">
                                            <video id="cameraStream" autoplay playsinline
                                                class="w-full rounded-2xl bg-gray-900"></video>
                                            <div class="mt-4 flex justify-center gap-3">
                                                <button type="button" id="btnCapture"
                                                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl font-bold hover:shadow-lg transition-all">
                                                    <i class="bi bi-camera-fill text-xl"></i>
                                                    Ambil Foto
                                                </button>
                                                <button type="button" id="btnCancelCamera"
                                                    class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-300 transition-all">
                                                    <i class="bi bi-x-circle"></i>
                                                    Batal
                                                </button>
                                            </div>
                                        </div>

                                        {{-- Preview Captured --}}
                                        <div id="capturedView" class="hidden">
                                            <canvas id="captureCanvas" class="w-full rounded-2xl"></canvas>
                                            <div class="mt-4 flex justify-center gap-3">
                                                <button type="button" id="btnUsePhoto"
                                                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-bold hover:shadow-lg transition-all">
                                                    <i class="bi bi-check-circle-fill text-xl"></i>
                                                    Gunakan Foto
                                                </button>
                                                <button type="button" id="btnRetake"
                                                    class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-300 transition-all">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                    Ambil Ulang
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Preview Image --}}
                            <div id="preview-container" class="mt-4 hidden">
                                <div class="relative inline-block">
                                    <img id="preview-image" src="" alt="Preview"
                                        class="max-w-md w-full rounded-2xl shadow-lg border-4 border-white">
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
                        </div>

                    </div>
                </div>

                {{-- Submit Buttons --}}
                <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-6 border-t-2 border-gray-100">
                    <a href="{{ route('landing') }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-300 transition-all">
                        <i class="bi bi-x-circle text-lg"></i>
                        Batal
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-bold hover:shadow-lg hover:shadow-blue-500/50 transition-all">
                        <i class="bi bi-save text-lg"></i>
                        Simpan Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // ========================================
        // CAMERA & FILE UPLOAD FUNCTIONALITY
        // ========================================
        (function() {
            let stream = null;
            let capturedImageBlob = null;

            const btnChooseFile = document.getElementById('btnChooseFile');
            const btnOpenCamera = document.getElementById('btnOpenCamera');
            const fileInput = document.getElementById('foto_peminjaman');
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

            // Choose File Button
            btnChooseFile.addEventListener('click', function() {
                fileInput.click();
            });

            // File Input Change - UPDATED VERSION (menggantikan yang lama)
            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                        photoSource.textContent = 'Foto dari file: ' + file.name;
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Open Camera Button
            btnOpenCamera.addEventListener('click', async function() {
                try {
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: 'environment', // Gunakan kamera belakang di mobile
                            width: {
                                ideal: 1920
                            },
                            height: {
                                ideal: 1080
                            }
                        }
                    });
                    cameraStream.srcObject = stream;
                    cameraModal.classList.remove('hidden');
                    cameraView.classList.remove('hidden');
                    capturedView.classList.add('hidden');
                } catch (error) {
                    console.error('Error accessing camera:', error);
                    alert('Tidak dapat mengakses kamera. Pastikan Anda memberikan izin akses kamera.');
                }
            });

            // Close Camera Modal
            function closeCamera() {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                }
                cameraModal.classList.add('hidden');
                cameraView.classList.remove('hidden');
                capturedView.classList.add('hidden');
            }

            btnCloseCamera.addEventListener('click', closeCamera);
            btnCancelCamera.addEventListener('click', closeCamera);

            // Capture Photo
            btnCapture.addEventListener('click', function() {
                const video = cameraStream;
                const canvas = captureCanvas;
                const context = canvas.getContext('2d');

                // Set canvas size to video size
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;

                // Draw video frame to canvas
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                // Show captured view
                cameraView.classList.add('hidden');
                capturedView.classList.remove('hidden');

                // Convert canvas to blob
                canvas.toBlob(function(blob) {
                    capturedImageBlob = blob;
                }, 'image/jpeg', 0.95);
            });

            // Retake Photo
            btnRetake.addEventListener('click', function() {
                cameraView.classList.remove('hidden');
                capturedView.classList.add('hidden');
                capturedImageBlob = null;
            });

            // Use Photo
            btnUsePhoto.addEventListener('click', function() {
                if (capturedImageBlob) {
                    // Create File from Blob
                    const fileName = 'camera-' + Date.now() + '.jpg';
                    const file = new File([capturedImageBlob], fileName, {
                        type: 'image/jpeg'
                    });

                    // Create DataTransfer to set files
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;

                    // Show preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                        photoSource.textContent = 'Foto dari kamera';
                    };
                    reader.readAsDataURL(file);

                    // Close camera
                    closeCamera();
                }
            });

            // Remove Preview
            btnRemovePreview.addEventListener('click', function() {
                fileInput.value = '';
                previewContainer.classList.add('hidden');
                previewImage.src = '';
                capturedImageBlob = null;
            });

            // Close modal when clicking outside
            cameraModal.addEventListener('click', function(e) {
                if (e.target === cameraModal) {
                    closeCamera();
                }
            });
        })();

        // ========================================
        // EXISTING CODE - ALAT SELECTION
        // ========================================
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ DOM Ready');
            console.log('✅ Choices available?', typeof Choices !== 'undefined');

            let alatIndex = 1;
            let selectedAlats = [];
            const alatsData = @json($alats);
            let choicesInstances = [];
            let alatCache = {}; // ✅ Cache global untuk menyimpan data alat by ID

            function formatKondisi(str) {
                if (!str) return '';
                return str.charAt(0).toUpperCase() + str.slice(1).replace(/_/g, ' ');
            }

            function updateNomorUrut() {
                document.querySelectorAll('.alat-item').forEach((item, index) => {
                    item.querySelector('.item-number').textContent = index + 1;
                });
            }

            function updateHapusButton() {
                const items = document.querySelectorAll('.alat-item');
                items.forEach((item, index) => {
                    const btnHapus = item.querySelector('.btn-hapus-alat');
                    btnHapus.style.display = items.length > 1 ? 'inline-flex' : 'none';
                });
            }

            function updateSelectedAlats() {
                selectedAlats = [];
                document.querySelectorAll('.select-alat').forEach(select => {
                    if (select.value) selectedAlats.push(select.value);
                });
            }

            function initChoices(selectElement, index) {
                console.log('🔧 Initializing Choices for index:', index);

                const choices = new Choices(selectElement, {
                    searchEnabled: true,
                    searchChoices: true,
                    searchFloor: 1,
                    searchResultLimit: 20,
                    placeholder: true,
                    placeholderValue: 'Ketik untuk mencari alat...',
                    noResultsText: 'Tidak ada alat ditemukan',
                    noChoicesText: 'Tidak ada pilihan',
                    itemSelectText: 'Klik untuk memilih',
                    shouldSort: false,
                    removeItemButton: false,
                });

                choicesInstances[index] = choices;

                // AJAX Search
                let searchTimeout;
                selectElement.addEventListener('search', function(event) {
                    clearTimeout(searchTimeout);
                    const searchTerm = event.detail.value;
                    if (searchTerm.length < 1) return;

                    const item = this.closest('.alat-item');
                    const idx = parseInt(item.dataset.index);

                    searchTimeout = setTimeout(() => {
                        fetch(
                                `{{ route('alat.search') }}?search=${encodeURIComponent(searchTerm)}`)
                            .then(response => response.json())
                            .then(data => {
                                const ci = choicesInstances[idx];
                                if (ci) {
                                    ci.clearChoices();
                                    ci.setChoices(data, 'value', 'label', true);
                                    // ✅ Simpan ke cache
                                    data.forEach(d => {
                                        alatCache[d.value] = d.customProperties;
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching alat:', error);
                            });
                    }, 300);
                });

                selectElement.addEventListener('showDropdown', function() {
                    const item = this.closest('.alat-item');
                    const idx = parseInt(item.dataset.index);
                    const ci = choicesInstances[idx];

                    if (!ci) return;

                    // Selalu muat ulang saat dropdown dibuka
                    ci.setChoices([{
                        value: '',
                        label: '⏳ Memuat...',
                        disabled: true
                    }], 'value', 'label', true);

                    fetch(`{{ route('alat.search') }}?search=`)
                        .then(response => response.json())
                        .then(data => {
                            ci.clearChoices();
                            ci.setChoices(data, 'value', 'label', true);
                            data.forEach(d => alatCache[d.value] = d.customProperties);
                        })
                        .catch(error => {
                            ci.clearChoices();
                            ci.setChoices([{
                                value: '',
                                label: '❌ Gagal memuat',
                                disabled: true
                            }], 'value', 'label', true);
                        });
                });

                // ✅ EVENT CHANGE - Gunakan alatCache
                selectElement.addEventListener('change', function(event) {
                    console.log('🔍 Change event triggered, value:', this.value);

                    const item = this.closest('.alat-item');
                    const jumlahInput = item.querySelector('.input-jumlah');
                    const jumlahTersediaSpan = item.querySelector('.jumlah-tersedia');
                    const kondisiSelect = item.querySelector('.select-kondisi');

                    if (this.value) {
                        const data = alatCache[this.value]; // ✅ Ambil dari cache

                        if (data) {
                            console.log('🔍 Data from cache:', data);

                            // Update jumlah tersedia
                            jumlahTersediaSpan.textContent = data.jumlah_tersedia || '0';
                            jumlahInput.max = data.jumlah_tersedia || 0;
                            jumlahInput.value = Math.min(jumlahInput.value || 1, data.jumlah_tersedia || 1);

                            // ✅ SET KONDISI OTOMATIS
                            if (kondisiSelect && data.kondisi) {
                                console.log('✅ Setting kondisi:', data.kondisi);
                                kondisiSelect.disabled = false;
                                kondisiSelect.value = data.kondisi;
                                kondisiSelect.disabled = true;
                                kondisiSelect.classList.add('bg-gray-100', 'cursor-not-allowed');
                                console.log('✅ Kondisi berhasil di-set:', kondisiSelect.value);
                            } else {
                                console.warn('⚠️ Data kondisi tidak valid atau tidak ditemukan');
                            }
                        } else {
                            console.warn('⚠️ Data alat tidak ditemukan di cache untuk ID:', this.value);
                        }
                    } else {
                        // Reset fields
                        jumlahTersediaSpan.textContent = '0';
                        jumlahInput.max = '';
                        jumlahInput.value = 1;

                        if (kondisiSelect) {
                            kondisiSelect.value = '';
                            kondisiSelect.disabled = false;
                            kondisiSelect.classList.remove('bg-gray-100', 'cursor-not-allowed');
                        }
                    }

                    updateSelectedAlats();
                });

                return choices;
            }

            // Validasi input jumlah
            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('input-jumlah')) {
                    const item = e.target.closest('.alat-item');
                    const select = item.querySelector('.select-alat');

                    if (select.value) {
                        const maxJumlah = parseInt(e.target.max);
                        const jumlah = parseInt(e.target.value);

                        if (jumlah > maxJumlah) {
                            alert('Jumlah melebihi stok yang tersedia!');
                            e.target.value = maxJumlah;
                        }
                    }
                }
            });

            // Tambah Alat Baru
            document.getElementById('btnTambahAlat').addEventListener('click', function() {
                const container = document.getElementById('containerAlat');
                const newItem = document.createElement('div');
                newItem.className =
                    'alat-item bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl p-6 border-2 border-gray-200';
                newItem.dataset.index = alatIndex;

                newItem.innerHTML = `
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-black text-gray-900">
                Alat #<span class="item-number">${alatIndex + 1}</span>
            </h3>
            <button type="button" class="btn-hapus-alat inline-flex items-center gap-2 px-3 py-2 bg-red-500 text-white rounded-lg font-bold text-sm hover:bg-red-600 transition-all">
                <i class="bi bi-trash"></i>
                Hapus
            </button>
        </div>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Alat <span class="text-red-500">*</span></label>
                <select class="select-alat w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        name="alat[${alatIndex}][alat_id]"
                        id="select-alat-${alatIndex}"
                        required>
                    <option value="">-- Cari dan Pilih Alat --</option>
                </select>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah <span class="text-red-500">*</span></label>
                    <input type="number" class="input-jumlah w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" name="alat[${alatIndex}][jumlah]" value="1" min="1">
                    <p class="mt-2 text-sm text-gray-500 font-medium">Tersedia: <span class="jumlah-tersedia text-green-600 font-bold">0</span> unit</p>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kondisi Alat <span class="text-red-500">*</span></label>
                    <select class="select-kondisi w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-100 cursor-not-allowed" name="alat[${alatIndex}][kondisi_alat]" disabled>
                        <option value="">-- Kondisi Otomatis --</option>
                        <option value="baik">Baik</option>
                        <option value="rusak">Rusak</option>
                    </select>
                    <p class="mt-2 text-sm text-gray-500">Kondisi diambil otomatis dari database alat</p>
                </div>
            </div>
        </div>
        `;

                container.appendChild(newItem);

                const newSelect = newItem.querySelector('.select-alat');
                initChoices(newSelect, alatIndex);

                alatIndex++;
                updateNomorUrut();
                updateHapusButton();
            });

            // Hapus Alat
            document.getElementById('containerAlat').addEventListener('click', function(e) {
                if (e.target.closest('.btn-hapus-alat')) {
                    const item = e.target.closest('.alat-item');
                    const index = item.dataset.index;

                    if (choicesInstances[index]) {
                        choicesInstances[index].destroy();
                        delete choicesInstances[index];
                    }

                    item.remove();
                    updateNomorUrut();
                    updateHapusButton();
                    updateSelectedAlats();
                }
            });

            // Form Submit Validation
            document.getElementById('formPeminjaman').addEventListener('submit', function(e) {
                // Enable semua select kondisi sebelum submit
                document.querySelectorAll('.select-kondisi').forEach(select => {
                    select.disabled = false;
                });

                const items = document.querySelectorAll('.alat-item');
                if (items.length === 0) {
                    e.preventDefault();
                    alert('Minimal harus meminjam 1 alat!');
                    return false;
                }

                let isValid = true;
                items.forEach((item, index) => {
                    const select = item.querySelector('.select-alat');
                    const jumlahInput = item.querySelector('.input-jumlah');
                    const kondisiSelect = item.querySelector('.select-kondisi');

                    if (!select.value) {
                        isValid = false;
                        alert(`Alat #${index + 1}: Silakan pilih alat!`);
                    } else if (!kondisiSelect.value) {
                        isValid = false;
                        alert(`Alat #${index + 1}: Kondisi alat belum terisi!`);
                    } else {
                        const maxJumlah = parseInt(jumlahInput.max);
                        const jumlah = parseInt(jumlahInput.value);
                        if (jumlah > maxJumlah) {
                            isValid = false;
                            alert(`Alat #${index + 1}: Jumlah melebihi stok yang tersedia!`);
                        }
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    document.querySelectorAll('.select-kondisi').forEach(select => {
                        if (select.value) {
                            select.disabled = true;
                        }
                    });
                    return false;
                }
            });

            // Initialize first select
            updateHapusButton();
            const firstSelect = document.querySelector('#select-alat-0');
            if (firstSelect) {
                console.log('✅ Initializing first select');
                initChoices(firstSelect, 0);
            } else {
                console.error('❌ First select not found!');
            }
        });
    </script>
@endpush
