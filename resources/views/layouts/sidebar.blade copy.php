<aside
    class="fixed inset-y-0 left-0 z-40 bg-slate-900 text-white transition-all duration-300 ease-in-out
           -translate-x-full lg:translate-x-0 shadow-2xl"
    :class="{
        'w-64': !sidebarMini,
        'w-20': sidebarMini,
        'translate-x-0': sidebarOpen
    }"
>
    {{-- Logo Header --}}
    <div class="h-16 flex items-center justify-between px-4 border-b border-slate-700 bg-gradient-to-r from-blue-600 to-indigo-600">
        <div class="flex items-center gap-3 overflow-hidden">
            {{-- <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center font-bold text-lg">
                <i class="bi bi-tools"></i>
            </div> --}}

                <img src="{{ asset('img/logo-black.png') }}" alt="Logo Rekaindo" class="w-12 h-6 object-contain">

            <div x-show="!sidebarMini" x-transition class="min-w-0">
                <p class="font-bold text-white truncate">Sistem Peminjaman Alat</p>
                <p class="text-xs text-blue-100 truncate">PPO - PT Rekaindo Global Jasa</p>
            </div>
        </div>
    </div>

    {{-- Scrollable Menu Area --}}
    <div class="overflow-y-auto h-[calc(100vh-4rem)] custom-scrollbar">
        <nav class="py-4 space-y-1">
            {{-- Main Menu Section --}}
            <div class="px-3 mb-4">
                <p
                    x-show="!sidebarMini"
                    x-transition
                    class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2"
                >
                    Main Menu
                </p>

                {{-- Dashboard --}}
                <a
                    href="{{ route('dashboard') }}"
                    class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200
                           {{ request()->routeIs('dashboard')
                              ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg'
                              : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                    :title="sidebarMini ? 'Dashboard' : ''"
                >
                    <i class="bi bi-speedometer2 text-lg {{ request()->routeIs('dashboard') ? '' : 'group-hover:scale-110 transition-transform' }}"></i>
                    <span x-show="!sidebarMini" x-transition class="font-medium">Dashboard</span>
                </a>
            </div>

            {{-- Transactions Section --}}
            <div class="px-3 mb-4">
                <p
                    x-show="!sidebarMini"
                    x-transition
                    class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2"
                >
                    Transaksi
                </p>

                {{-- Peminjaman --}}
                <a
                    href="{{ route('peminjaman.index') }}"
                    class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 relative
                           {{ request()->routeIs('peminjaman.*')
                              ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg'
                              : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                    :title="sidebarMini ? 'Peminjaman' : ''"
                >
                    <i class="bi bi-journal-check text-lg {{ request()->routeIs('peminjaman.*') ? '' : 'group-hover:scale-110 transition-transform' }}"></i>
                    <span x-show="!sidebarMini" x-transition class="font-medium flex-1">Peminjaman</span>
                    @php
                        $activePeminjaman = \App\Models\Peminjaman::where('status', 'dipinjam')->count();
                    @endphp
                    @if($activePeminjaman > 0)
                        <span
                            x-show="!sidebarMini"
                            x-transition
                            class="px-2 py-0.5 bg-yellow-500 text-white text-xs font-bold rounded-full"
                        >
                            {{ $activePeminjaman }}
                        </span>
                        <span
                            x-show="sidebarMini"
                            class="absolute -top-1 -right-1 w-5 h-5 bg-yellow-500 text-white text-xs font-bold rounded-full flex items-center justify-center"
                        >
                            {{ $activePeminjaman }}
                        </span>
                    @endif
                </a>
            </div>

            {{-- Master Data Section --}}
            <div class="px-3 mb-4">
                <p
                    x-show="!sidebarMini"
                    x-transition
                    class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2"
                >
                    Master Data
                </p>

                {{-- Data Alat --}}
                <a
                    href="{{ route('alat.index') }}"
                    class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200
                           {{ request()->routeIs('alat.*')
                              ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg'
                              : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                    :title="sidebarMini ? 'Data Alat' : ''"
                >
                    <i class="bi bi-box-seam text-lg {{ request()->routeIs('alat.*') ? '' : 'group-hover:scale-110 transition-transform' }}"></i>
                    <span x-show="!sidebarMini" x-transition class="font-medium">Data Alat</span>
                </a>

                {{-- Data Peminjam --}}
                <a
                    href="{{ route('peminjam.index') }}"
                    class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200
                           {{ request()->routeIs('peminjam.*')
                              ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg'
                              : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                    :title="sidebarMini ? 'Data Peminjam' : ''"
                >
                    <i class="bi bi-people text-lg {{ request()->routeIs('peminjam.*') ? '' : 'group-hover:scale-110 transition-transform' }}"></i>
                    <span x-show="!sidebarMini" x-transition class="font-medium">Data Peminjam</span>
                </a>
            </div>

            {{-- Divider --}}
            <div class="mx-3 border-t border-slate-700 my-4"></div>

            {{-- Other Section --}}
            <div class="px-3">
                <p
                    x-show="!sidebarMini"
                    x-transition
                    class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2"
                >
                    Lainnya
                </p>

                {{-- Portal Publik --}}
                <a
                    href="{{ route('landing') }}"
                    target="_blank"
                    class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 text-slate-300 hover:bg-slate-800 hover:text-white"
                    :title="sidebarMini ? 'Portal Publik' : ''"
                >
                    <i class="bi bi-box-arrow-up-right text-lg group-hover:scale-110 transition-transform"></i>
                    <span x-show="!sidebarMini" x-transition class="font-medium">Portal Publik</span>
                </a>

                {{-- Logout --}}
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="group w-full flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 text-red-400 hover:bg-red-900/20 hover:text-red-300"
                        :title="sidebarMini ? 'Logout' : ''"
                    >
                        <i class="bi bi-box-arrow-right text-lg group-hover:scale-110 transition-transform"></i>
                        <span x-show="!sidebarMini" x-transition class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </nav>
    </div>
</aside>

{{-- Overlay Mobile --}}
<div
    x-show="sidebarOpen"
    @click="sidebarOpen = false"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 lg:hidden"
></div>

<style>
    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 5px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }
</style>
