@extends('layouts.public')

@section('title', 'Cari Peminjaman')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="main-card">
            <div class="card-header-custom">
                <h4><i class="bi bi-search"></i> Cari Peminjaman</h4>
            </div>
            <div class="card-body-custom">
                <div class="text-center mb-4">
                    <i class="bi bi-arrow-return-left" style="font-size: 5rem; color: #667eea;"></i>
                    <h5 class="mt-3">Masukkan Kode Peminjaman</h5>
                    <p class="text-muted">
                        Silakan masukkan kode peminjaman yang Anda terima saat melakukan peminjaman alat.
                        Kode peminjaman berbentuk: <strong>PJM-YYYYMMDD-XXXX</strong>
                    </p>
                </div>

                <form action="{{ route('pengembalian.proses-cari') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="kode_peminjaman" class="form-label">Kode Peminjaman <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control form-control-lg text-center @error('kode_peminjaman') is-invalid @enderror"
                               id="kode_peminjaman"
                               name="kode_peminjaman"
                               value="{{ old('kode_peminjaman') }}"
                               placeholder="Contoh: PJM-20250101-0001"
                               style="font-size: 1.2rem; letter-spacing: 2px; font-weight: bold;"
                               required autofocus>
                        @error('kode_peminjaman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary-custom btn-lg">
                            <i class="bi bi-search"></i> Cari Peminjaman
                        </button>
                        <a href="{{ route('landing') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                        </a>
                    </div>
                </form>

                <!-- Info Box -->
                <div class="alert alert-info mt-4">
                    <h6 class="alert-heading"><i class="bi bi-info-circle"></i> Informasi</h6>
                    <hr>
                    <ul class="mb-0 small">
                        <li>Kode peminjaman diberikan saat Anda melakukan peminjaman alat</li>
                        <li>Pastikan kode yang dimasukkan sesuai dengan yang Anda terima</li>
                        <li>Jika lupa kode peminjaman, silakan hubungi administrator</li>
                        <li>Pengembalian hanya bisa dilakukan untuk peminjaman yang masih aktif</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
