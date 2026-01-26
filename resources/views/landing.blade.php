@extends('layouts.public')

@section('title', 'TAMS - Tools Assets Management System')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Hero Section --}}
    <div class="text-center mb-12">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center">
            <img src="{{ asset('img/logo-white.png') }}" alt="REKAINDO GLOBAL JASA" class="h-20 w-auto">
        </a>
        <h1 class="text-5xl md:text-6xl font-black text-white mb-4 drop-shadow-lg">
            TAMS
        </h1>
        <p class="text-xl md:text-2xl text-white/90 font-semibold drop-shadow-md">
            Tools Assets Management System
        </p>
        <div class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-white/20 backdrop-blur-lg rounded-2xl border-2 border-white/30">
            <i class="bi bi-building text-white text-lg"></i>
            <span class="text-white font-bold">PT REKAINDO GLOBAL JASA</span>
        </div>
    </div>

    {{-- Action Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        {{-- Card Peminjaman --}}
        <div class="group bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 hover:shadow-green-500/20 transition-all duration-500 hover:-translate-y-2">
            {{-- Card Header --}}
            <div class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform duration-300">
                        <i class="bi bi-plus-circle-fill text-white text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-white">Form Peminjaman</h3>
                        <p class="text-green-100 text-sm font-medium mt-1">Pinjam alat untuk kebutuhan pekerjaan</p>
                    </div>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="p-8">
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl mb-4">
                        <i class="bi bi-tools text-5xl bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent"></i>
                    </div>
                    <p class="text-gray-600 text-base leading-relaxed">
                        Ajukan peminjaman alat dengan mengisi formulir peminjaman secara online. Proses cepat dan mudah!
                    </p>
                </div>

                {{-- Features List --}}
                <div class="space-y-3 mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-check-circle-fill text-green-600 text-sm"></i>
                        </div>
                        <span class="text-sm text-gray-700 font-medium">Formulir peminjaman digital</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-check-circle-fill text-green-600 text-sm"></i>
                        </div>
                        <span class="text-sm text-gray-700 font-medium">Pilih beberapa alat sekaligus</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-check-circle-fill text-green-600 text-sm"></i>
                        </div>
                        <span class="text-sm text-gray-700 font-medium">Dapatkan kode peminjaman otomatis</span>
                    </div>
                </div>

                {{-- Button --}}
                <a href="{{ route('peminjaman.create') }}"
                   class="w-full inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-black text-lg rounded-2xl hover:from-green-700 hover:to-emerald-700 focus:ring-4 focus:ring-green-200 transition-all shadow-lg hover:shadow-xl hover:shadow-green-500/50 transform hover:-translate-y-0.5">
                    <i class="bi bi-arrow-right-circle text-xl"></i>
                    Pinjam Alat
                </a>
            </div>
        </div>

        {{-- Card Pengembalian --}}
        <div class="group bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 hover:shadow-yellow-500/20 transition-all duration-500 hover:-translate-y-2">
            {{-- Card Header --}}
            <div class="bg-gradient-to-r from-yellow-500 via-amber-500 to-orange-500 px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform duration-300">
                        <i class="bi bi-arrow-return-left text-white text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-white">Form Pengembalian</h3>
                        <p class="text-yellow-100 text-sm font-medium mt-1">Kembalikan alat yang telah dipinjam</p>
                    </div>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="p-8">
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-yellow-100 to-orange-100 rounded-2xl mb-4">
                        <i class="bi bi-box-seam text-5xl bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent"></i>
                    </div>
                    <p class="text-gray-600 text-base leading-relaxed">
                        Kembalikan alat yang telah dipinjam dengan mengisi formulir pengembalian. Mudah dan terdata dengan baik!
                    </p>
                </div>

                {{-- Features List --}}
                <div class="space-y-3 mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-check-circle-fill text-yellow-600 text-sm"></i>
                        </div>
                        <span class="text-sm text-gray-700 font-medium">Cari dengan kode peminjaman</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-check-circle-fill text-yellow-600 text-sm"></i>
                        </div>
                        <span class="text-sm text-gray-700 font-medium">Laporkan kondisi alat</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-check-circle-fill text-yellow-600 text-sm"></i>
                        </div>
                        <span class="text-sm text-gray-700 font-medium">Upload foto pengembalian</span>
                    </div>
                </div>

                {{-- Button --}}
                <a href="{{ route('pengembalian.cari') }}"
                   class="w-full inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-yellow-500 to-orange-500 text-white font-black text-lg rounded-2xl hover:from-yellow-600 hover:to-orange-600 focus:ring-4 focus:ring-yellow-200 transition-all shadow-lg hover:shadow-xl hover:shadow-yellow-500/50 transform hover:-translate-y-0.5">
                    <i class="bi bi-arrow-left-circle text-xl"></i>
                    Kembalikan Alat
                </a>
            </div>
        </div>
    </div>

    {{-- Info Banner --}}
    <div class="bg-white/10 backdrop-blur-lg rounded-3xl border-2 border-white/30 p-8 shadow-2xl">
        <div class="flex flex-col md:flex-row items-center gap-6">
            <div class="flex-shrink-0">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center">
                    <i class="bi bi-info-circle-fill text-white text-3xl"></i>
                </div>
            </div>
            <div class="flex-1 text-center md:text-left">
                <h3 class="text-xl font-black text-white mb-2">Butuh Bantuan?</h3>
                <p class="text-white/80 text-sm leading-relaxed">
                    Jika Anda mengalami kesulitan atau memiliki pertanyaan, silakan hubungi administrator sistem untuk mendapatkan bantuan.
                </p>
            </div>
            <div class="flex-shrink-0">
                <a href="https://wa.me/6285156613540"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-white text-blue-600 font-bold rounded-xl hover:bg-blue-50 transition-all shadow-lg">
                    <i class="bi bi-phone-fill"></i>
                    Hubungi Admin
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Animate cards on load
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.group');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            setTimeout(() => {
                card.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 200);
        });

        // Parallax effect on mouse move
        document.addEventListener('mousemove', function(e) {
            const cards = document.querySelectorAll('.group');
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;

            cards.forEach((card, index) => {
                const depth = (index + 1) * 10;
                const moveX = (x - 0.5) * depth;
                const moveY = (y - 0.5) * depth;
                card.style.transform = `translate(${moveX}px, ${moveY}px)`;
            });
        });
    });
</script>
@endpush
@endsection
