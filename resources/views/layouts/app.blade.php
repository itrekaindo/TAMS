<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', config('app.name', 'Sistem Peminjaman Alat'))</title>
    {{-- favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('icon-reka.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    {{-- Sweet Alert 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('styles')
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/30 antialiased">
<div
    x-data="{
        sidebarOpen: false,
        sidebarMini: localStorage.getItem('sidebarMini') === 'true' || false,
        toggleMini() {
            this.sidebarMini = !this.sidebarMini;
            localStorage.setItem('sidebarMini', this.sidebarMini);
        }
    }"
    class="flex min-h-screen"
>
    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Content --}}
    <div
        class="flex-1 transition-all duration-300 ease-in-out"
        :class="{
            'lg:ml-64': !sidebarMini,
            'lg:ml-20': sidebarMini
        }"
    >
        {{-- Topbar --}}
        <header class="sticky top-0 z-30 h-16 bg-white/80 backdrop-blur-xl border-b border-slate-200/60 shadow-sm">
            <div class="flex items-center justify-between h-full px-4 lg:px-6">
                <div class="flex items-center gap-4">
                    {{-- Desktop Toggle --}}
                    <button
                        @click="toggleMini()"
                        class="hidden lg:flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-slate-100 to-slate-50 hover:from-blue-50 hover:to-indigo-50 border border-slate-200/60 hover:border-blue-300/60 transition-all duration-200 shadow-sm hover:shadow group"
                        title="Toggle Sidebar"
                    >
                        <i class="bi bi-list text-xl text-slate-700 group-hover:text-blue-600 transition-colors"></i>
                    </button>
                    {{-- Mobile Toggle --}}
                    <button
                        @click="sidebarOpen = true"
                        class="lg:hidden flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-slate-100 to-slate-50 hover:from-blue-50 hover:to-indigo-50 border border-slate-200/60 hover:border-blue-300/60 transition-all duration-200 shadow-sm hover:shadow group"
                    >
                        <i class="bi bi-list text-xl text-slate-700 group-hover:text-blue-600 transition-colors"></i>
                    </button>

                    {{-- Page Title --}}
                    <div>
                        <h1 class="text-lg lg:text-xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">
                            @yield('page-title', 'Dashboard')
                        </h1>
                        <p class="text-xs text-slate-500 hidden sm:block">@yield('page-subtitle', 'Kelola data dengan mudah')</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    {{-- Date Badge --}}
                    <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl text-sm text-white font-semibold shadow-lg shadow-blue-500/30">
                        <i class="bi bi-calendar3"></i>
                        <span>{{ now()->isoFormat('D MMMM Y') }}</span>
                    </div>

                    {{-- Notification Button --}}
                    {{-- <button class="relative flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-slate-100 to-slate-50 hover:from-blue-50 hover:to-indigo-50 border border-slate-200/60 hover:border-blue-300/60 transition-all duration-200 shadow-sm hover:shadow group">
                        <i class="bi bi-bell text-lg text-slate-700 group-hover:text-blue-600 transition-colors"></i>
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-r from-red-500 to-pink-500 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-lg ring-2 ring-white">
                            3
                        </span>
                    </button> --}}

                    {{-- User Dropdown --}}
                    <div x-data="{ open: false }" class="relative">
                        <button
                            @click="open = !open"
                            class="flex items-center gap-3 px-3 py-2 rounded-xl bg-gradient-to-br from-slate-100 to-slate-50 hover:from-blue-50 hover:to-indigo-50 border border-slate-200/60 hover:border-blue-300/60 transition-all duration-200 shadow-sm hover:shadow"
                        >
                            <div class="w-9 h-9 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-semibold text-slate-700">
                                    {{ Auth::user()->name ?? 'Admin' }}
                                </p>
                                <p class="text-xs text-slate-500">Administrator</p>
                            </div>
                            <i class="bi bi-chevron-down text-xs text-slate-500 transition-transform" :class="{ 'rotate-180': open }"></i>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div
                            x-show="open"
                            @click.away="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-64 bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-slate-200/60 py-2 z-50 overflow-hidden"
                        >
                            <div class="px-4 py-3 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                                        <p class="text-xs text-slate-600 truncate">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="py-2">
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 transition-colors group">
                                    <i class="bi bi-person-circle text-lg text-slate-500 group-hover:text-blue-600"></i>
                                    <span class="font-medium">Profil Saya</span>
                                </a>
                                {{-- <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 transition-colors group">
                                    <i class="bi bi-gear text-lg text-slate-500 group-hover:text-blue-600"></i>
                                    <span class="font-medium">Pengaturan</span>
                                </a> --}}
                                <a href="{{ route('landing') }}" target="_blank" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 transition-colors group">
                                    <i class="bi bi-box-arrow-up-right text-lg text-slate-500 group-hover:text-blue-600"></i>
                                    <span class="font-medium">Portal Publik</span>
                                </a>
                            </div>

                            <div class="border-t border-slate-100 mt-2 pt-2">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors group">
                                        <i class="bi bi-box-arrow-right text-lg group-hover:translate-x-1 transition-transform"></i>
                                        <span class="font-semibold">Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="p-4 lg:p-6">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="py-6 px-4 lg:px-6 border-t border-slate-200/60 bg-white/50 backdrop-blur-sm">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-slate-600">
                <p>&copy; {{ date('Y') }} <span class="font-semibold text-slate-800">PT Rekaindo Global Jasa</span>. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-blue-600 transition-colors font-medium">Bantuan</a>

                    <div x-data="{ open: false }" class="relative">
                        <button
                            @click="open = !open"
                            class="hover:text-blue-600 transition-colors font-medium flex items-center gap-1.5"
                        >
                            Dokumentasi
                            <i
                                class="bi bi-chevron-up text-xs transition-transform duration-200"
                                :class="{ 'rotate-180': open }"
                            ></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div
                            x-show="open"
                            @click.away="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-2"
                            style="bottom: calc(100% + 0.5rem);"
                            class="absolute right-0 w-60 bg-white/95 backdrop-blur-xl rounded-xl shadow-xl border border-slate-200/60 overflow-hidden z-50"
                        >
                            <div class="py-1">
                                <a
                                    href="{{ asset('templates/MANUAL_USER.pdf') }}"
                                    download
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200 group"
                                >
                                    <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="bi bi-file-earmark-pdf text-lg text-red-500"></i>
                                    </div>
                                    <span class="font-medium">Panduan Pengguna</span>
                                </a>
                                <a
                                    href="{{ asset('templates/MANUAL_ADMIN.pdf') }}"
                                    download
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200 group"
                                >
                                    <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="bi bi-file-earmark-pdf text-lg text-red-500"></i>
                                    </div>
                                    <span class="font-medium">Panduan Admin</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="hover:text-blue-600 transition-colors font-medium">Kontak</a>
                </div>
            </div>
        </footer>
    </div>
</div>

@yield('scripts')

{{-- Sweet Alert Auto Trigger --}}
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            toast: true,
            position: 'top-end',
            background: '#fff',
            iconColor: '#10b981',
            customClass: {
                popup: 'colored-toast'
            }
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#EF4444',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'px-6 py-2.5 rounded-xl font-semibold shadow-lg'
            }
        });
    </script>
@endif

@if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan!',
            html: '<ul class="text-left space-y-1 mt-2">@foreach($errors->all() as $error)<li class="text-sm">• {{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#EF4444',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'px-6 py-2.5 rounded-xl font-semibold shadow-lg'
            }
        });
    </script>
@endif

<style>
    /* Custom Sweet Alert Styling */
    .colored-toast.swal2-icon-success {
        background-color: #10b981 !important;
    }

    .swal2-popup {
        border-radius: 1rem !important;
        font-family: inherit !important;
    }

    .swal2-title {
        font-weight: 800 !important;
    }
</style>
</body>
</html>
