<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', config('app.name', 'Sistem Peminjaman Alat'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    @yield('styles')
</head>
<body class="bg-gray-50 antialiased">
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
        <header class="sticky top-0 z-30 h-16 bg-white border-b border-gray-200 shadow-sm">
            <div class="flex items-center justify-between h-full px-4 lg:px-6">
                <div class="flex items-center gap-4">
                    {{-- Desktop Toggle --}}
                    <button
                        @click="toggleMini()"
                        class="hidden lg:flex items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-100 transition-colors"
                        title="Toggle Sidebar"
                    >
                        <i class="bi bi-list text-xl text-gray-700"></i>
                    </button>
                    {{-- Mobile Toggle --}}
                    <button
                        @click="sidebarOpen = true"
                        class="lg:hidden flex items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-100 transition-colors"
                    >
                        <i class="bi bi-list text-xl text-gray-700"></i>
                    </button>

                    {{-- Page Title --}}
                    <h1 class="text-lg lg:text-xl font-bold text-gray-800">
                        @yield('page-title', 'Dashboard')
                    </h1>
                </div>

                <div class="flex items-center gap-4">
                    {{-- Date Badge --}}
                    <div class="hidden md:flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg text-sm text-blue-700 font-medium">
                        <i class="bi bi-calendar3"></i>
                        <span>{{ now()->isoFormat('D MMMM Y') }}</span>
                    </div>

                    {{-- User Dropdown --}}
                    <div x-data="{ open: false }" class="relative">
                        <button
                            @click="open = !open"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors"
                        >
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <span class="hidden md:block text-sm font-medium text-gray-700">
                                {{ Auth::user()->name ?? 'Admin' }}
                            </span>
                            <i class="bi bi-chevron-down text-xs text-gray-500"></i>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div
                            x-show="open"
                            @click.away="open = false"
                            x-transition
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50"
                        >
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'Admin' }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
                            </div>
                            <a href="{{ route('landing') }}" target="_blank" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="bi bi-box-arrow-up-right"></i>
                                <span>Portal Publik</span>
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="p-4 lg:p-6">
            {{-- Alert Messages --}}
            @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition class="mb-4 flex items-start gap-3 p-4 bg-green-50 border border-green-200 rounded-lg">
                <i class="bi bi-check-circle-fill text-green-600 text-xl"></i>
                <div class="flex-1">
                    <p class="font-medium text-green-900">Berhasil!</p>
                    <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-green-600 hover:text-green-800">
                    <i class="bi bi-x text-xl"></i>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition class="mb-4 flex items-start gap-3 p-4 bg-red-50 border border-red-200 rounded-lg">
                <i class="bi bi-exclamation-triangle-fill text-red-600 text-xl"></i>
                <div class="flex-1">
                    <p class="font-medium text-red-900">Error!</p>
                    <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-red-600 hover:text-red-800">
                    <i class="bi bi-x text-xl"></i>
                </button>
            </div>
            @endif

            @if($errors->any())
            <div x-data="{ show: true }" x-show="show" x-transition class="mb-4 flex items-start gap-3 p-4 bg-red-50 border border-red-200 rounded-lg">
                <i class="bi bi-exclamation-triangle-fill text-red-600 text-xl"></i>
                <div class="flex-1">
                    <p class="font-medium text-red-900">Terjadi Kesalahan!</p>
                    <ul class="text-sm text-red-700 mt-2 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button @click="show = false" class="text-red-600 hover:text-red-800">
                    <i class="bi bi-x text-xl"></i>
                </button>
            </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@yield('scripts')
</body>
</html>
