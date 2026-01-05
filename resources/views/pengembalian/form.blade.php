@extends('layouts.public')

@section('title', 'Form Pengembalian Alat')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="main-card">
            <div class="card-header-custom">
                <h4><i class="bi bi-arrow-return-left"></i> Form Pengembalian Alat</h4>
            </div>
            <div class="card-body-custom">
                <!-- Info Peminjaman -->
                <div class="alert alert-info">
                    <h6 class="alert-heading"><i class="bi bi-info-circle"></i> Informasi Peminjaman</h6>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Kode Peminjaman:</strong> {{ $peminjaman->kode_peminjaman }}</p>
                            <p class="mb-1"><strong>Nama Peminjam:</strong> {{ $peminjaman->peminjam->nama_lengkap }}</p>
                            <p class="mb-1"><strong>NIP:</strong> {{ $peminjaman->peminjam->nip }}</p>
                            <p class="mb-1"><strong>Departemen:</strong> {{ $peminjaman->peminjam->departemen }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Tanggal Pinjam:</strong> {{ $peminjaman->tanggal_pinjam->isoFormat('D MMMM Y') }}</p>
                            <p class="mb-1"><strong>Rencana Kembali:</strong> {{ $peminjaman->tanggal_kembali_rencana->isoFormat('D MMMM Y') }}</p>
                            <p class="mb-0"><strong>Total Alat:</strong> {{ $peminjaman->details->count() }} jenis alat</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            @if($peminjaman->isLate())
                                <div class="alert alert-warning mb-0 py-2">
                                    <i class="bi bi-exclamation-triangle"></i> <strong>Terlambat!</strong><br>
                                    <small>Sudah melewati tanggal rencana pengembalian</small>
                                </div>
                            @else
                                <div class="alert alert-success mb-0 py-2">
                                    <i class="bi bi-check-circle"></i> <strong>Tepat Waktu</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Foto Peminjaman -->
                @if($peminjaman->foto_peminjaman)
                <div class="mb-4">
                    <h6 class="section-title"><i class="bi bi-image"></i> Foto Saat Peminjaman</h6>
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $peminjaman->foto_peminjaman) }}"
                             alt="Foto Peminjaman" class="img-thumbnail" style="max-width: 400px;">
                    </div>
                </div>
                @endif

                <!-- Form Pengembalian -->
                <form action="{{ route('pengembalian.submit', $peminjaman->id) }}"
                      method="POST" enctype="multipart/form-data" id="formPengembalian">
                    @csrf

                    <!-- Daftar Alat yang Dipinjam -->
                    <div class="mb-4">
                        <h5 class="section-title">
                            <i class="bi bi-box-seam"></i> Daftar Alat yang Dipinjam
                        </h5>

                        @foreach($peminjaman->details as $index => $detail)
                        <div class="card mb-3 alat-card" data-kondisi-pinjam="{{ $detail->kondisi_alat }}">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="bi bi-box"></i> Alat #{{ $index + 1 }}: {{ $detail->nama_alat }}
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong>Kode Alat:</strong><br>
                                        <span class="badge bg-secondary">{{ $detail->kode_alat }}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Jumlah Dipinjam:</strong><br>
                                        <span class="badge bg-info">{{ $detail->jumlah }} unit</span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Kondisi Saat Pinjam:</strong><br>
                                        <span class="badge bg-primary kondisi-pinjam">
                                            {{ \App\Models\Peminjaman::kondisiOptions()[$detail->kondisi_alat] ?? $detail->kondisi_alat }}
                                        </span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Kondisi Alat Saat Dikembalikan <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select kondisi-select @error('detail.'.$detail->id.'.kondisi_alat_kembali') is-invalid @enderror"
                                                name="detail[{{ $detail->id }}][kondisi_alat_kembali]"
                                                data-detail-id="{{ $detail->id }}"
                                                required>
                                            <option value="">-- Pilih Kondisi --</option>
                                            @foreach(\App\Models\Peminjaman::kondisiOptions() as $key => $value)
                                                <option value="{{ $key }}" {{ old('detail.'.$detail->id.'.kondisi_alat_kembali') == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('detail.'.$detail->id.'.kondisi_alat_kembali')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Keterangan (Opsional)</label>
                                        <textarea class="form-control @error('detail.'.$detail->id.'.keterangan') is-invalid @enderror"
                                                  name="detail[{{ $detail->id }}][keterangan]" rows="2"
                                                  placeholder="Catatan: kerusakan, kehilangan komponen, dll">{{ old('detail.'.$detail->id.'.keterangan') }}</textarea>
                                        @error('detail.'.$detail->id.'.keterangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Warning per alat -->
                                <div class="alert alert-warning warning-kondisi" style="display: none;">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    <strong>Peringatan!</strong> Kondisi alat saat dikembalikan berbeda dengan kondisi saat peminjaman.
                                    Pastikan Anda telah mengisi keterangan dengan benar.
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Data Pengembalian Umum -->
                    <div class="mb-4">
                        <h5 class="section-title">
                            <i class="bi bi-clipboard-check"></i> Data Pengembalian
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_kembali" class="form-label">Tanggal Pengembalian</label>
                                <input type="text" class="form-control bg-light" id="tanggal_kembali"
                                       value="{{ now()->isoFormat('D MMMM Y') }}" readonly>
                                <small class="text-muted">Diisi otomatis saat pengembalian</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="foto_pengembalian" class="form-label">
                                    Upload Foto Pengembalian <span class="text-danger">*</span>
                                </label>
                                <input type="file" class="form-control @error('foto_pengembalian') is-invalid @enderror"
                                       id="foto_pengembalian" name="foto_pengembalian" accept="image/*" required>
                                <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                                @error('foto_pengembalian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <!-- Preview Image -->
                                <div id="preview-container" style="display: none;">
                                    <p class="mb-2"><strong>Preview Foto:</strong></p>
                                    <img id="preview-image" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px;">
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="keterangan_pengembalian" class="form-label">
                                    Keterangan Umum Pengembalian (Opsional)
                                </label>
                                <textarea class="form-control @error('keterangan_pengembalian') is-invalid @enderror"
                                          id="keterangan_pengembalian" name="keterangan_pengembalian" rows="3"
                                          placeholder="Catatan umum tentang pengembalian semua alat">{{ old('keterangan_pengembalian') }}</textarea>
                                @error('keterangan_pengembalian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Pernyataan -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="pernyataan" required>
                            <label class="form-check-label" for="pernyataan">
                                Saya menyatakan bahwa data yang saya masukkan adalah benar dan semua alat dikembalikan sesuai kondisi yang dilaporkan
                            </label>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('pengembalian.cari') }}" class="btn btn-secondary btn-lg">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary-custom btn-lg">
                            <i class="bi bi-check-circle"></i> Proses Pengembalian
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
    // Preview gambar
    document.getElementById('foto_pengembalian').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            // Validasi ukuran file
            if (file.size > 2048000) {
                alert('Ukuran file terlalu besar! Maksimal 2MB');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
                document.getElementById('preview-container').style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    // Warning jika kondisi memburuk untuk setiap alat
    document.querySelectorAll('.kondisi-select').forEach(select => {
        select.addEventListener('change', function() {
            const card = this.closest('.alat-card');
            const kondisiPinjam = card.dataset.kondisiPinjam;
            const kondisiKembali = this.value;
            const warning = card.querySelector('.warning-kondisi');

            // Tampilkan warning jika kondisi berbeda dan memburuk
            if (kondisiKembali && kondisiKembali !== kondisiPinjam && kondisiKembali !== 'baik') {
                warning.style.display = 'block';
                card.classList.add('border-warning');
            } else {
                warning.style.display = 'none';
                card.classList.remove('border-warning');
            }
        });
    });

    // Validasi dan konfirmasi sebelum submit
    document.getElementById('formPengembalian').addEventListener('submit', function(e) {
        let isValid = true;
        let emptyCount = 0;
        let changedCount = 0;
        const kondisiSelects = document.querySelectorAll('.kondisi-select');

        // Validasi semua kondisi sudah dipilih
        kondisiSelects.forEach((select, index) => {
            if (!select.value) {
                isValid = false;
                emptyCount++;
            } else {
                // Hitung berapa alat yang kondisinya berubah
                const card = select.closest('.alat-card');
                const kondisiPinjam = card.dataset.kondisiPinjam;
                if (select.value !== kondisiPinjam && select.value !== 'baik') {
                    changedCount++;
                }
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert(`Ada ${emptyCount} alat yang kondisinya belum dipilih! Silakan lengkapi semua kondisi alat.`);
            return false;
        }

        // Konfirmasi jika ada perubahan kondisi
        if (changedCount > 0) {
            const confirmMsg = `Terdapat ${changedCount} alat yang kondisinya berbeda dari saat peminjaman.\n\n` +
                              `Apakah Anda yakin ingin melanjutkan?`;
            if (!confirm(confirmMsg)) {
                e.preventDefault();
                return false;
            }
        }

        // Konfirmasi final
        const finalMsg = `Apakah Anda yakin ingin memproses pengembalian ${kondisiSelects.length} jenis alat ini?\n\n` +
                        `Pastikan semua data sudah benar.`;

        if (!confirm(finalMsg)) {
            e.preventDefault();
            return false;
        }
    });
</script>
@endsection
