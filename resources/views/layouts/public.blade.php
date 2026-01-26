<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Peminjaman Alat - PT Rekaindo Global Jasa')</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('icon-reka.ico') }}">

    {{-- Tailwind CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    {{-- Choices.js CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">

    <style>
        /* Gradient Background */
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }

        /* Animated Gradient Background */
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .animated-bg {
            background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #4facfe);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Styling untuk search input agar lebih terlihat */
        .choices__list--dropdown .choices__input {
            display: block !important;
            width: 100% !important;
            padding: 10px 12px !important;
            margin-bottom: 8px !important;
            border: 2px solid #e5e7eb !important;
            border-radius: 8px !important;
            background-color: #f9fafb !important;
            font-size: 14px !important;
        }

        .choices__list--dropdown .choices__input:focus {
            border-color: #3b82f6 !important;
            background-color: #ffffff !important;
            outline: none !important;
        }

        /* Styling dropdown list */
        .choices__list--dropdown {
            padding: 8px !important;
            max-height: 300px !important;
            overflow-y: auto !important;
        }

        /* Item di dropdown */
        .choices__item--selectable {
            padding: 10px 12px !important;
            border-radius: 6px !important;
            margin-bottom: 4px !important;
        }

        .choices__item--selectable:hover,
        .choices__item--selectable.is-highlighted {
            background-color: #dbeafe !important;
        }

        /* Container dropdown */
        .choices[data-type*=select-one] .choices__inner {
            padding: 12px 16px !important;
        }
    </style>

    @stack('styles')
</head>
<body class="animated-bg">
    {{-- Navbar --}}
    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-lg shadow-lg border-b border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Brand Logo --}}
                <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <img src="{{ asset('img/logo-black.png') }}" alt="Logo" class="w-full h-full object-contain">
                    </div>
                    <div class="hidden md:block">
                        <p class="text-lg font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 leading-tight">
                            Tools Assets
                        </p>
                        <p class="text-xs text-gray-500 font-semibold leading-tight">
                            Management System
                        </p>
                    </div>
                </a>

                {{-- Desktop Navigation --}}
                <div class="hidden md:flex items-center gap-2">
                    <a href="{{ route('landing') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all {{ request()->routeIs('landing') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="bi bi-house-door text-lg"></i>
                        <span>Beranda</span>
                    </a>
                    <a href="{{ route('peminjaman.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all {{ request()->routeIs('peminjaman.create') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="bi bi-plus-circle text-lg"></i>
                        <span>Form Peminjaman</span>
                    </a>
                    <a href="{{ route('pengembalian.cari') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all {{ request()->routeIs('pengembalian.cari') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="bi bi-arrow-return-left text-lg"></i>
                        <span>Form Pengembalian</span>
                    </a>
                </div>

                {{-- Mobile Menu Button --}}
                <button
                    x-data="{ open: false }"
                    @click="open = !open"
                    class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl hover:bg-gray-100 transition-colors">
                    <i class="bi bi-list text-2xl text-gray-700"></i>
                </button>
            </div>

            {{-- Mobile Navigation --}}
            <div
                x-data="{ open: false }"
                x-show="open"
                @click.away="open = false"
                x-transition
                class="md:hidden pb-4 space-y-2"
                style="display: none;">
                <a href="{{ route('landing') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-all {{ request()->routeIs('landing') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="bi bi-house-door text-lg"></i>
                    <span>Beranda</span>
                </a>
                <a href="{{ route('peminjaman.create') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-all {{ request()->routeIs('peminjaman.create') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="bi bi-plus-circle text-lg"></i>
                    <span>Form Peminjaman</span>
                </a>
                <a href="{{ route('pengembalian.cari') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-all {{ request()->routeIs('pengembalian.cari') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="bi bi-arrow-return-left text-lg"></i>
                    <span>Form Pengembalian</span>
                </a>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Alert Messages --}}
        @if(session('success'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            class="mb-6 flex items-start gap-4 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg shadow-sm">
            <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-check-circle-fill text-green-600 text-xl"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-green-900">Berhasil!</p>
                <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
            </div>
            <button
                @click="show = false"
                class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-green-100 text-green-600 hover:text-green-800 transition-colors">
                <i class="bi bi-x text-xl"></i>
            </button>
        </div>
        @endif

        @if(session('error'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            class="mb-6 flex items-start gap-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg shadow-sm">
            <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-exclamation-triangle-fill text-red-600 text-xl"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-red-900">Error!</p>
                <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
            </div>
            <button
                @click="show = false"
                class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-red-100 text-red-600 hover:text-red-800 transition-colors">
                <i class="bi bi-x text-xl"></i>
            </button>
        </div>
        @endif

        @if($errors->any())
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            class="mb-6 flex items-start gap-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg shadow-sm">
            <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-exclamation-triangle-fill text-red-600 text-xl"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-red-900">Terjadi Kesalahan Validasi!</p>
                <ul class="text-sm text-red-700 mt-2 space-y-1 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button
                @click="show = false"
                class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-red-100 text-red-600 hover:text-red-800 transition-colors">
                <i class="bi bi-x text-xl"></i>
            </button>
        </div>
        @endif

        {{-- Page Content --}}
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="mt-16 pb-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 shadow-xl">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="bi bi-building text-white text-xl"></i>
                        </div>
                        <div class="text-white">
                            <p class="font-bold text-sm">PT REKAINDO GLOBAL JASA</p>
                            <p class="text-xs text-blue-100">Tools Assets Management System</p>
                        </div>
                    </div>
                    <div class="text-center md:text-right">
                        <p class="text-white text-sm font-medium">&copy; {{ date('Y') }} All rights reserved.</p>
                        <p class="text-blue-100 text-xs mt-1">by Teknologi Informasi</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    {{-- Alpine.js for Mobile Menu --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- Choices.js Script - Letakkan sebelum @stack('scripts') --}}


    @stack('scripts')
</body>
</html>
