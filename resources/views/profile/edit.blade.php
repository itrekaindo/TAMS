@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi akun dan pengaturan keamanan')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm">
        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-blue-600 transition-colors font-medium">
            <i class="bi bi-house-door"></i>
            Dashboard
        </a>
        <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
        <span class="text-gray-900 font-semibold">Profil Saya</span>
    </nav>

    {{-- Profile Header Card --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 rounded-3xl shadow-2xl">
        {{-- Animated Background --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-white rounded-full mix-blend-overlay filter blur-xl animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-white rounded-full mix-blend-overlay filter blur-xl animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-white rounded-full mix-blend-overlay filter blur-xl animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative z-10 p-8">
            <div class="flex flex-col md:flex-row items-center gap-6">
                {{-- Avatar --}}
                <div class="relative">
                    <div class="w-24 h-24 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white font-black text-4xl shadow-2xl border-4 border-white/30">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-full border-4 border-white flex items-center justify-center">
                        <i class="bi bi-check text-white text-sm font-bold"></i>
                    </div>
                </div>

                {{-- User Info --}}
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-3xl font-black text-white mb-2">{{ Auth::user()->name ?? 'User' }}</h1>
                    <p class="text-blue-100 font-medium text-lg mb-4">{{ Auth::user()->email ?? 'email@example.com' }}</p>
                    <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/20 backdrop-blur-md text-white rounded-lg text-sm font-semibold border border-white/30">
                            <i class="bi bi-shield-check"></i>
                            {{ Auth::user()->role ?? 'Administrator' }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/20 backdrop-blur-md text-white rounded-lg text-sm font-semibold border border-white/30">
                            <i class="bi bi-calendar-check"></i>
                            Bergabung {{ Auth::user()->created_at?->format('M Y') ?? 'N/A' }}
                        </span>
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div class="hidden lg:flex gap-4">
                    <div class="bg-white/10 backdrop-blur-lg rounded-2xl px-6 py-4 border border-white/20 text-center">
                        <p class="text-xs text-blue-100 font-medium mb-1">Login Terakhir</p>
                        <p class="text-xl font-black text-white">{{ Auth::user()->updated_at?->diffForHumans() ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Profile Forms --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Update Profile Information --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-6 py-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="bi bi-person-circle text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900">Informasi Profil</h3>
                            <p class="text-sm text-gray-500 font-medium mt-0.5">Perbarui informasi akun dan email Anda</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        {{-- Quick Info Sidebar --}}
        <div class="space-y-6">
            {{-- Account Security --}}
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100">
                <div class="flex items-start gap-3 mb-4">
                    <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                        <i class="bi bi-shield-check text-white text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-black text-gray-900 mb-1">Keamanan Akun</h4>
                        <p class="text-sm text-gray-600 font-medium leading-relaxed">
                            Akun Anda terlindungi dengan enkripsi tingkat tinggi
                        </p>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center gap-2 text-sm">
                        <i class="bi bi-check-circle-fill text-green-600"></i>
                        <span class="text-gray-700 font-medium">Email terverifikasi</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm">
                        <i class="bi bi-check-circle-fill text-green-600"></i>
                        <span class="text-gray-700 font-medium">Password terenkripsi</span>
                    </div>
                </div>
            </div>

            {{-- Help Center --}}
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-100">
                <div class="flex items-start gap-3 mb-4">
                    <div class="w-10 h-10 bg-purple-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                        <i class="bi bi-question-circle text-white text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-black text-gray-900 mb-1">Butuh Bantuan?</h4>
                        <p class="text-sm text-gray-600 font-medium leading-relaxed">
                            Hubungi tim support untuk bantuan
                        </p>
                    </div>
                </div>
                <a href="https://wa.me/6285156613540" class="inline-flex items-center gap-2 px-4 py-2.5 bg-purple-600 text-white rounded-xl font-bold text-sm hover:bg-purple-700 transition-all w-full justify-center">
                    <i class="bi bi-headset"></i>
                    Hubungi Support
                </a>
            </div>
        </div>
    </div>

    {{-- Update Password --}}
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-gray-50 to-orange-50 px-6 py-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-key-fill text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-gray-900">Ubah Password</h3>
                    <p class="text-sm text-gray-500 font-medium mt-0.5">Pastikan akun Anda menggunakan password yang kuat dan aman</p>
                </div>
            </div>
        </div>
        <div class="p-6">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- Delete Account --}}
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-red-200">
        <div class="bg-gradient-to-r from-red-50 to-pink-50 px-6 py-5 border-b border-red-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-exclamation-triangle-fill text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-gray-900">Zona Berbahaya</h3>
                    <p class="text-sm text-gray-500 font-medium mt-0.5">Hapus akun Anda secara permanen - tindakan ini tidak dapat dibatalkan</p>
                </div>
            </div>
        </div>
        <div class="p-6">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>

{{-- Blob Animation --}}
<style>
    @keyframes blob {
        0%, 100% {
            transform: translate(0, 0) scale(1);
        }
        25% {
            transform: translate(20px, -50px) scale(1.1);
        }
        50% {
            transform: translate(-20px, 20px) scale(0.9);
        }
        75% {
            transform: translate(50px, 50px) scale(1.05);
        }
    }

    .animate-blob {
        animation: blob 7s infinite;
    }

    .animation-delay-2000 {
        animation-delay: 2s;
    }

    .animation-delay-4000 {
        animation-delay: 4s;
    }
</style>
@endsection
