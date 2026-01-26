@extends('layouts.public')

@section('title', 'Cari Peminjaman')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header Card --}}
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-8 py-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center shadow-xl">
                    <i class="bi bi-search text-white text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-black text-white">Cari Peminjaman</h1>
                    <p class="text-blue-100 text-sm font-medium mt-1">Masukkan kode peminjaman untuk proses pengembalian</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
        <div class="p-8 md:p-10">
            {{-- Icon & Description --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-28 h-28 bg-gradient-to-br from-blue-100 via-indigo-100 to-purple-100 rounded-3xl mb-6 shadow-lg">
                    <i class="bi bi-arrow-return-left text-7xl bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent"></i>
                </div>
                <h5 class="text-2xl font-black text-gray-900 mb-3">Masukkan Kode Peminjaman</h5>
                <p class="text-gray-600 text-sm leading-relaxed max-w-lg mx-auto">
                    Silakan masukkan kode peminjaman yang Anda terima saat melakukan peminjaman alat.
                </p>
                <div class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-2 border-blue-200">
                    <i class="bi bi-info-circle-fill text-blue-600"></i>
                    <span class="text-sm font-bold text-blue-900">Format: <span class="font-mono">PJM-YYYYMMDD-XXXX</span></span>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('pengembalian.proses-cari') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="kode_peminjaman" class="block text-sm font-bold text-gray-700 mb-3">
                        Kode Peminjaman <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           class="w-full px-6 py-5 text-center text-xl font-black tracking-widest border-2 border-gray-300 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all placeholder:font-normal placeholder:text-base @error('kode_peminjaman') border-red-500 focus:ring-red-100 focus:border-red-500 @enderror"
                           id="kode_peminjaman"
                           name="kode_peminjaman"
                           value="{{ old('kode_peminjaman') }}"
                           placeholder="Contoh: PJM-20250101-0001"
                           required
                           autofocus>
                    @error('kode_peminjaman')
                        <div class="mt-3 flex items-start gap-2 p-3 bg-red-50 border-l-4 border-red-500 rounded-lg">
                            <i class="bi bi-exclamation-circle-fill text-red-600 mt-0.5"></i>
                            <p class="text-sm text-red-700 font-semibold">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="space-y-3 pt-4">
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-3 px-8 py-5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-black text-lg rounded-2xl hover:from-blue-700 hover:to-indigo-700 focus:ring-4 focus:ring-blue-200 transition-all shadow-lg hover:shadow-xl hover:shadow-blue-500/50 transform hover:-translate-y-0.5">
                        <i class="bi bi-search text-xl"></i>
                        Cari Peminjaman
                    </button>
                    <a href="{{ route('landing') }}"
                       class="w-full inline-flex items-center justify-center gap-2 px-6 py-4 bg-gray-200 text-gray-700 font-bold rounded-2xl hover:bg-gray-300 focus:ring-4 focus:ring-gray-200 transition-all">
                        <i class="bi bi-arrow-left text-lg"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </form>

            {{-- Divider --}}
            <div class="border-t-2 border-gray-100 my-8"></div>

            {{-- Info Box --}}
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl border-2 border-blue-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-info-circle-fill text-white text-xl"></i>
                    </div>
                    <h6 class="font-black text-blue-900 text-lg">Informasi Penting</h6>
                </div>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-6 h-6 bg-blue-200 rounded-lg flex items-center justify-center mt-0.5">
                            <i class="bi bi-check-circle-fill text-blue-600 text-sm"></i>
                        </div>
                        <p class="text-sm text-blue-800 font-medium">Kode peminjaman diberikan saat Anda melakukan peminjaman alat</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-6 h-6 bg-blue-200 rounded-lg flex items-center justify-center mt-0.5">
                            <i class="bi bi-check-circle-fill text-blue-600 text-sm"></i>
                        </div>
                        <p class="text-sm text-blue-800 font-medium">Pastikan kode yang dimasukkan sesuai dengan yang Anda terima</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-6 h-6 bg-blue-200 rounded-lg flex items-center justify-center mt-0.5">
                            <i class="bi bi-check-circle-fill text-blue-600 text-sm"></i>
                        </div>
                        <p class="text-sm text-blue-800 font-medium">Jika lupa kode peminjaman, silakan hubungi administrator</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-6 h-6 bg-blue-200 rounded-lg flex items-center justify-center mt-0.5">
                            <i class="bi bi-check-circle-fill text-blue-600 text-sm"></i>
                        </div>
                        <p class="text-sm text-blue-800 font-medium">Pengembalian hanya bisa dilakukan untuk peminjaman yang masih aktif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto format input kode peminjaman
    document.getElementById('kode_peminjaman').addEventListener('input', function(e) {
        // Convert to uppercase
        this.value = this.value.toUpperCase();
    });

    // Animate card on load
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.bg-white');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 150);
        });
    });
</script>
@endpush
@endsection
