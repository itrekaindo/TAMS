@extends('layouts.public')

@section('title', 'Form Peminjaman Alat')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="main-card">
            <div class="card-header-custom">
                <h4><i class="bi bi-plus-circle"></i> Form Peminjaman Alat</h4>
            </div>
            <div class="card-body-custom">
                <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data" id="formPeminjaman">
                    @csrf

                    <!-- Data Peminjam -->
                    <div class="mb-4">
                        <h5 class="section-title">
                            <i class="bi bi-person-fill"></i> Data Peminjam
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                       id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                       placeholder="Masukkan nama lengkap" required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nip" class="form-label">NIP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror"
                                       id="nip" name="nip" value="{{ old('nip') }}"
                                       placeholder="Masukkan NIP" required>
                                @error('nip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="departemen" class="form-label">Departemen/Bagian <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('departemen') is-invalid @enderror"
                                       id="departemen" name="departemen" value="{{ old('departemen') }}"
                                       placeholder="Contoh: IT Support, Teknik, Administrasi" required>
                                @error('departemen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}"
                                       placeholder="Masukkan email" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="telepon" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                                       id="telepon" name="telepon" value="{{ old('telepon') }}"
                                       placeholder="Contoh: 081234567890" required>
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Data Alat (Multiple) -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="section-title mb-0">
                                <i class="bi bi-box-seam"></i> Data Alat yang Dipinjam
                            </h5>
                            <button type="button" class="btn btn-success btn-sm" id="btnTambahAlat">
                                <i class="bi bi-plus-circle"></i> Tambah Alat
                            </button>
                        </div>

                        <!-- Container untuk item alat -->
                        <div id="containerAlat">
                            <!-- Item alat pertama -->
                            <div class="alat-item card mb-3" data-index="0">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0">Alat #<span class="item-number">1</span></h6>
                                        <button type="button" class="btn btn-danger btn-sm btn-hapus-alat" style="display: none;">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Pilih Alat <span class="text-danger">*</span></label>
                                            <select class="form-select select-alat @error('alat.0.alat_id') is-invalid @enderror"
                                                    name="alat[0][alat_id]" required>
                                                <option value="">-- Pilih Alat yang Akan Dipinjam --</option>
                                                @foreach($alats as $alat)
                                                    <option value="{{ $alat->id }}"
                                                            data-kode="{{ $alat->kode_alat }}"
                                                            data-nama="{{ $alat->nama_alat }}"
                                                            data-tersedia="{{ $alat->jumlah_tersedia }}"
                                                            {{ old('alat.0.alat_id') == $alat->id ? 'selected' : '' }}>
                                                        {{ $alat->nama_alat }} ({{ $alat->kode_alat }}) - Tersedia: {{ $alat->jumlah_tersedia }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('alat.0.alat_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control input-jumlah @error('alat.0.jumlah') is-invalid @enderror"
                                                   name="alat[0][jumlah]" value="{{ old('alat.0.jumlah', 1) }}" min="1" required>
                                            <small class="text-muted">Tersedia: <span class="jumlah-tersedia">0</span></small>
                                            @error('alat.0.jumlah')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Kondisi Alat <span class="text-danger">*</span></label>
                                            <select class="form-select @error('alat.0.kondisi_alat') is-invalid @enderror"
                                                    name="alat[0][kondisi_alat]" required>
                                                <option value="">-- Pilih Kondisi --</option>
                                                @foreach(\App\Models\Peminjaman::kondisiOptions() as $key => $value)
                                                    <option value="{{ $key }}" {{ old('alat.0.kondisi_alat') == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('alat.0.kondisi_alat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @error('alat')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Data Peminjaman -->
                    <div class="mb-4">
                        <h5 class="section-title">
                            <i class="bi bi-calendar-check"></i> Detail Peminjaman
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_pinjam" class="form-label">Tanggal Peminjaman</label>
                                <input type="text" class="form-control bg-light" id="tanggal_pinjam"
                                       value="{{ now()->isoFormat('D MMMM Y') }}" readonly>
                                <small class="text-muted">Diisi otomatis saat peminjaman</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_kembali_rencana" class="form-label">Tanggal Rencana Pengembalian <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_kembali_rencana') is-invalid @enderror"
                                       id="tanggal_kembali_rencana" name="tanggal_kembali_rencana"
                                       value="{{ old('tanggal_kembali_rencana') }}"
                                       min="{{ now()->format('Y-m-d') }}" required>
                                @error('tanggal_kembali_rencana')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="keperluan" class="form-label">Keperluan <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('keperluan') is-invalid @enderror"
                                          id="keperluan" name="keperluan" rows="3"
                                          placeholder="Jelaskan untuk apa alat ini akan digunakan" required>{{ old('keperluan') }}</textarea>
                                @error('keperluan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="foto_peminjaman" class="form-label">Upload Foto <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('foto_peminjaman') is-invalid @enderror"
                                       id="foto_peminjaman" name="foto_peminjaman" accept="image/*" required>
                                <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                                @error('foto_peminjaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <!-- Preview Image -->
                                <div id="preview-container" class="mt-3" style="display: none;">
                                    <img id="preview-image" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('landing') }}" class="btn btn-secondary btn-lg">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary-custom btn-lg">
                            <i class="bi bi-save"></i> Simpan Peminjaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let alatIndex = 1;
    let selectedAlats = []; // Untuk tracking alat yang sudah dipilih

    // Data alat dari server
    const alatsData = @json($alats);

    // Fungsi untuk update nomor urut
    function updateNomorUrut() {
        document.querySelectorAll('.alat-item').forEach((item, index) => {
            item.querySelector('.item-number').textContent = index + 1;
        });
    }

    // Fungsi untuk update visibility tombol hapus
    function updateHapusButton() {
        const items = document.querySelectorAll('.alat-item');
        items.forEach((item, index) => {
            const btnHapus = item.querySelector('.btn-hapus-alat');
            if (items.length > 1) {
                btnHapus.style.display = 'inline-block';
            } else {
                btnHapus.style.display = 'none';
            }
        });
    }

    // Fungsi untuk membuat options select alat
    function createAlatOptions(excludeIds = []) {
        let options = '<option value="">-- Pilih Alat yang Akan Dipinjam --</option>';
        alatsData.forEach(alat => {
            if (!excludeIds.includes(alat.id.toString())) {
                options += `<option value="${alat.id}"
                    data-kode="${alat.kode_alat}"
                    data-nama="${alat.nama_alat}"
                    data-tersedia="${alat.jumlah_tersedia}">
                    ${alat.nama_alat} (${alat.kode_alat}) - Tersedia: ${alat.jumlah_tersedia}
                </option>`;
            }
        });
        return options;
    }

    // Fungsi untuk update selected alats
    function updateSelectedAlats() {
        selectedAlats = [];
        document.querySelectorAll('.select-alat').forEach(select => {
            if (select.value) {
                selectedAlats.push(select.value);
            }
        });
    }

    // Fungsi untuk update semua select options
    function updateAllSelectOptions() {
        updateSelectedAlats();
        document.querySelectorAll('.select-alat').forEach(select => {
            const currentValue = select.value;
            const excludeIds = selectedAlats.filter(id => id !== currentValue);
            const newOptions = createAlatOptions(excludeIds);
            select.innerHTML = newOptions;
            if (currentValue) {
                select.value = currentValue;
            }
        });
    }

    // Event listener untuk select alat
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('select-alat')) {
            const item = e.target.closest('.alat-item');
            const selectedOption = e.target.options[e.target.selectedIndex];
            const jumlahInput = item.querySelector('.input-jumlah');
            const jumlahTersediaSpan = item.querySelector('.jumlah-tersedia');

            if (e.target.value) {
                const tersedia = selectedOption.dataset.tersedia;
                jumlahTersediaSpan.textContent = tersedia;
                jumlahInput.max = tersedia;
                jumlahInput.value = Math.min(jumlahInput.value || 1, tersedia);
            } else {
                jumlahTersediaSpan.textContent = '0';
                jumlahInput.max = '';
            }

            updateAllSelectOptions();
        }
    });

    // Event listener untuk input jumlah
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

    // Tombol tambah alat
    document.getElementById('btnTambahAlat').addEventListener('click', function() {
        const container = document.getElementById('containerAlat');

        const newItem = document.createElement('div');
        newItem.className = 'alat-item card mb-3';
        newItem.dataset.index = alatIndex;

        newItem.innerHTML = `
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Alat #<span class="item-number">${alatIndex + 1}</span></h6>
                    <button type="button" class="btn btn-danger btn-sm btn-hapus-alat">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Pilih Alat <span class="text-danger">*</span></label>
                        <select class="form-select select-alat" name="alat[${alatIndex}][alat_id]" required>
                            ${createAlatOptions(selectedAlats)}
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" class="form-control input-jumlah"
                               name="alat[${alatIndex}][jumlah]" value="1" min="1" required>
                        <small class="text-muted">Tersedia: <span class="jumlah-tersedia">0</span></small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kondisi Alat <span class="text-danger">*</span></label>
                        <select class="form-select" name="alat[${alatIndex}][kondisi_alat]" required>
                            <option value="">-- Pilih Kondisi --</option>
                            @foreach(\App\Models\Peminjaman::kondisiOptions() as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        `;

        container.appendChild(newItem);
        alatIndex++;

        updateNomorUrut();
        updateHapusButton();
    });

    // Event delegation untuk tombol hapus
    document.getElementById('containerAlat').addEventListener('click', function(e) {
        if (e.target.closest('.btn-hapus-alat')) {
            const item = e.target.closest('.alat-item');
            item.remove();
            updateNomorUrut();
            updateHapusButton();
            updateAllSelectOptions();
        }
    });

    // Preview gambar
    document.getElementById('foto_peminjaman').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
                document.getElementById('preview-container').style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    // Validasi form sebelum submit
    document.getElementById('formPeminjaman').addEventListener('submit', function(e) {
        let isValid = true;
        const items = document.querySelectorAll('.alat-item');

        // Cek apakah minimal ada 1 alat
        if (items.length === 0) {
            e.preventDefault();
            alert('Minimal harus meminjam 1 alat!');
            return false;
        }

        // Validasi setiap item
        items.forEach((item, index) => {
            const select = item.querySelector('.select-alat');
            const jumlahInput = item.querySelector('.input-jumlah');

            if (!select.value) {
                isValid = false;
                alert(`Alat #${index + 1}: Silakan pilih alat!`);
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
            return false;
        }
    });

    // Initialize pada load
    document.addEventListener('DOMContentLoaded', function() {
        updateHapusButton();

        // Auto-fill untuk item pertama jika ada old input
        const firstSelect = document.querySelector('.select-alat');
        if (firstSelect && firstSelect.value) {
            firstSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endsection
