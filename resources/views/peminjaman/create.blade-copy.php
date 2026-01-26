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
                                <div>
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
                                            class="select-kondisi w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-100 cursor-not-allowed @error('alat.0.kondisi_alat') border-red-500 @enderror"
                                            name="alat[0][kondisi_alat]" required disabled>
                                            <option value="">-- Kondisi Otomatis --</option>
                                            <option value="baik">Baik</option>
                                            <option value="rusak_ringan">Rusak Ringan</option>
                                            <option value="rusak_berat">Rusak Berat</option>
                                            <option value="maintenance">Maintenance</option>
                                        </select>
                                        <p class="mt-2 text-sm text-gray-500">Kondisi diambil otomatis dari database alat</p>
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
                            <input type="file"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('foto_peminjaman') border-red-500 @enderror"
                                id="foto_peminjaman" name="foto_peminjaman" accept="image/*" required>
                            <p class="mt-2 text-sm text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
                            @error('foto_peminjaman')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                    {{ $message }}
                                </p>
                            @enderror

                            {{-- Preview Image --}}
                            <div id="preview-container" class="mt-4 hidden">
                                <img id="preview-image" src="" alt="Preview"
                                    class="max-w-md w-full rounded-2xl shadow-lg border-4 border-white">
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
        let alatIndex = 1;
        let selectedAlats = [];
        const alatsData = @json($alats);

        // Fungsi helper untuk capitalize dan format kondisi
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

        // Update fungsi createAlatOptions untuk menambahkan data-kondisi
        function createAlatOptions(excludeIds = []) {
            let options = '<option value="">-- Pilih Alat yang Akan Dipinjam --</option>';
            alatsData.forEach(alat => {
                if (!excludeIds.includes(alat.id.toString())) {
                    options += `<option value="${alat.id}"
                        data-kode="${alat.kode_alat}"
                        data-nama="${alat.nama_alat}"
                        data-tersedia="${alat.jumlah_tersedia}"
                        data-kondisi="${alat.kondisi}">
                        ${alat.nama_alat} (${alat.kode_alat}) - Tersedia: ${alat.jumlah_tersedia} - Kondisi: ${formatKondisi(alat.kondisi)}
                    </option>`;
                }
            });
            return options;
        }

        function updateSelectedAlats() {
            selectedAlats = [];
            document.querySelectorAll('.select-alat').forEach(select => {
                if (select.value) selectedAlats.push(select.value);
            });
        }

        function updateAllSelectOptions() {
            updateSelectedAlats();
            document.querySelectorAll('.select-alat').forEach(select => {
                const currentValue = select.value;
                const excludeIds = selectedAlats.filter(id => id !== currentValue);
                select.innerHTML = createAlatOptions(excludeIds);
                if (currentValue) select.value = currentValue;
            });
        }

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('select-alat')) {
                const item = e.target.closest('.alat-item');
                const selectedOption = e.target.options[e.target.selectedIndex];
                const jumlahInput = item.querySelector('.input-jumlah');
                const jumlahTersediaSpan = item.querySelector('.jumlah-tersedia');
                const kondisiSelect = item.querySelector('.select-kondisi');

                if (e.target.value) {
                    const tersedia = selectedOption.dataset.tersedia;
                    const kondisi = selectedOption.dataset.kondisi;

                    jumlahTersediaSpan.textContent = tersedia;
                    jumlahInput.max = tersedia;
                    jumlahInput.value = Math.min(jumlahInput.value || 1, tersedia);

                    // SET KONDISI OTOMATIS
                    if (kondisiSelect) {
                        kondisiSelect.value = kondisi;
                        kondisiSelect.disabled = true;
                        kondisiSelect.classList.add('bg-gray-100', 'cursor-not-allowed');
                    }
                } else {
                    jumlahTersediaSpan.textContent = '0';
                    jumlahInput.max = '';

                    // RESET KONDISI
                    if (kondisiSelect) {
                        kondisiSelect.value = '';
                        kondisiSelect.disabled = false;
                        kondisiSelect.classList.remove('bg-gray-100', 'cursor-not-allowed');
                    }
                }
                updateAllSelectOptions();
            }
        });

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
                    <select class="select-alat w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" name="alat[${alatIndex}][alat_id]" required>
                        ${createAlatOptions(selectedAlats)}
                    </select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah <span class="text-red-500">*</span></label>
                        <input type="number" class="input-jumlah w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" name="alat[${alatIndex}][jumlah]" value="1" min="1" required>
                        <p class="mt-2 text-sm text-gray-500 font-medium">Tersedia: <span class="jumlah-tersedia text-green-600 font-bold">0</span> unit</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kondisi Alat <span class="text-red-500">*</span></label>
                        <select class="select-kondisi w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-100 cursor-not-allowed" name="alat[${alatIndex}][kondisi_alat]" required disabled>
                            <option value="">-- Kondisi Otomatis --</option>
                            <option value="baik">Baik</option>
                            <option value="rusak_ringan">Rusak Ringan</option>
                            <option value="rusak_berat">Rusak Berat</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                        <p class="mt-2 text-sm text-gray-500">Kondisi diambil otomatis dari database alat</p>
                    </div>
                </div>
            </div>
        `;

            container.appendChild(newItem);
            alatIndex++;
            updateNomorUrut();
            updateHapusButton();
        });

        document.getElementById('containerAlat').addEventListener('click', function(e) {
            if (e.target.closest('.btn-hapus-alat')) {
                e.target.closest('.alat-item').remove();
                updateNomorUrut();
                updateHapusButton();
                updateAllSelectOptions();
            }
        });

        document.getElementById('foto_peminjaman').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('preview-container').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('formPeminjaman').addEventListener('submit', function(e) {
            // Enable semua select kondisi sebelum submit agar data terkirim
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
                // Re-disable kondisi select jika validasi gagal
                document.querySelectorAll('.select-kondisi').forEach(select => {
                    if (select.value) {
                        select.disabled = true;
                    }
                });
                return false;
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            updateHapusButton();
            const firstSelect = document.querySelector('.select-alat');
            if (firstSelect && firstSelect.value) {
                firstSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endpush
