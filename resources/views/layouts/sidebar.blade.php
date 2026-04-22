<aside
    class="fixed inset-y-0 left-0 z-40 bg-gradient-to-b from-slate-900 via-slate-900 to-slate-800 text-white transition-all duration-300 ease-in-out
           -translate-x-full lg:translate-x-0"
    :class="{
        'w-64': !sidebarMini,
        'w-20': sidebarMini,
        'translate-x-0': sidebarOpen
    }"
    style="box-shadow: 4px 0 24px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(255, 255, 255, 0.05);"
>
    {{-- Logo Header --}}
    <div class="h-16 flex items-center justify-between px-4 border-b border-white/10 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 relative overflow-hidden">
        {{-- Animated Background --}}
        <div class="absolute inset-0 bg-gradient-to-r from-blue-400/20 to-purple-400/20 animate-pulse"></div>

        <div class="flex items-center gap-3 overflow-hidden relative z-10">
            <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center shadow-lg ring-2 ring-white/30">
                <img src="{{ asset('img/logo-black.png') }}" alt="Logo" class="w-8 h-8 object-contain filter brightness-0 invert">
            </div>

            <div x-show="!sidebarMini" x-transition class="min-w-0">
                <p class="font-bold text-white truncate text-sm tracking-wide">Sistem Peminjaman Alat</p>
                <p class="text-xs text-blue-100/90 truncate font-medium">PPO - PT Rekaindo Global Jasa</p>
            </div>
        </div>
    </div>

    {{-- Scrollable Menu Area --}}
    <div class="overflow-y-auto h-[calc(100vh-4rem)] custom-scrollbar">
        <nav class="py-6 space-y-2">
            {{-- Main Menu Section --}}
            <div class="px-3 mb-6">
                <p
                    x-show="!sidebarMini"
                    x-transition
                    class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 px-3"
                >
                    Main Menu
                </p>

                {{-- Dashboard - Accessible by ALL roles --}}
                <a
                    href="{{ route('dashboard') }}"
                    class="group flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200 relative overflow-hidden
                           {{ request()->routeIs('dashboard')
                              ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/50'
                              : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                    :title="sidebarMini ? 'Dashboard' : ''"
                >
                    @if(request()->routeIs('dashboard'))
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-400/20 to-indigo-400/20 animate-pulse"></div>
                    @endif
                    <div class="relative z-10 flex items-center gap-3 w-full">
                        <i class="bi bi-speedometer2 text-xl {{ request()->routeIs('dashboard') ? '' : 'group-hover:scale-110 transition-transform' }}"></i>
                        <span x-show="!sidebarMini" x-transition class="font-semibold text-sm">Dashboard</span>
                    </div>
                </a>
            </div>

            {{-- Transactions Section - Accessible by ALL roles --}}
            <div class="px-3 mb-6">
                <p
                    x-show="!sidebarMini"
                    x-transition
                    class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 px-3"
                >
                    Transaksi
                </p>

                {{-- Peminjaman --}}
                <a
                    href="{{ route('peminjaman.index') }}"
                    class="group flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200 relative overflow-hidden
                           {{ request()->routeIs('peminjaman.*')
                              ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/50'
                              : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                    :title="sidebarMini ? 'Peminjaman' : ''"
                >
                    @if(request()->routeIs('peminjaman.*'))
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-400/20 to-indigo-400/20 animate-pulse"></div>
                    @endif
                    <div class="relative z-10 flex items-center gap-3 w-full">
                        <i class="bi bi-journal-check text-xl {{ request()->routeIs('peminjaman.*') ? '' : 'group-hover:scale-110 transition-transform' }}"></i>
                        <span x-show="!sidebarMini" x-transition class="font-semibold text-sm flex-1">Peminjaman</span>
                        @php
                            $activePeminjaman = \App\Models\Peminjaman::where('status', 'dipinjam')->count();
                        @endphp
                        @if($activePeminjaman > 0)
                            <span
                                x-show="!sidebarMini"
                                x-transition
                                class="px-2.5 py-1 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-bold rounded-full shadow-lg"
                            >
                                {{ $activePeminjaman }}
                            </span>
                            <span
                                x-show="sidebarMini"
                                class="absolute -top-1 -right-1 w-6 h-6 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-bold rounded-full flex items-center justify-center shadow-lg ring-2 ring-slate-900"
                            >
                                {{ $activePeminjaman }}
                            </span>
                        @endif
                    </div>
                </a>
            </div>

            {{-- Master Data Section - Role-based access --}}
            @if(Auth::check())
                @php
                    $userRole = Auth::user()->role ?? 'toolskeeper';
                    $canAccessMasterData = in_array($userRole, ['admin', 'superadmin']);
                    $canAccessAlat = in_array($userRole, ['admin', 'superadmin']);
                    $canAccessPeminjam = in_array($userRole, ['admin', 'superadmin', 'toolskeeper']);
                @endphp

                {{-- Show Master Data section if user has access to at least one menu --}}
                @if($canAccessMasterData || $canAccessPeminjam)
                    <div class="px-3 mb-6">
                        <p
                            x-show="!sidebarMini"
                            x-transition
                            class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 px-3"
                        >
                            Master Data
                        </p>

                        {{-- Data Alat - Only for admin & superadmin --}}
                        @if($canAccessAlat)
                            <a
                                href="{{ route('alat.index') }}"
                                class="group flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200 relative overflow-hidden
                                       {{ request()->routeIs('alat.*')
                                          ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/50'
                                          : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                                :title="sidebarMini ? 'Data Alat' : ''"
                            >
                                @if(request()->routeIs('alat.*'))
                                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400/20 to-indigo-400/20 animate-pulse"></div>
                                @endif
                                <div class="relative z-10 flex items-center gap-3 w-full">
                                    <i class="bi bi-box-seam text-xl {{ request()->routeIs('alat.*') ? '' : 'group-hover:scale-110 transition-transform' }}"></i>
                                    <span x-show="!sidebarMini" x-transition class="font-semibold text-sm">Data Alat</span>
                                </div>
                            </a>
                        @endif

                        {{-- Data Peminjam - For admin, superadmin, and toolskeeper --}}
                        @if($canAccessPeminjam)
                            <a
                                href="{{ route('peminjam.index') }}"
                                class="group flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200 relative overflow-hidden
                                       {{ request()->routeIs('peminjam.*')
                                          ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/50'
                                          : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                                :title="sidebarMini ? 'Data Peminjam' : ''"
                            >
                                @if(request()->routeIs('peminjam.*'))
                                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400/20 to-indigo-400/20 animate-pulse"></div>
                                @endif
                                <div class="relative z-10 flex items-center gap-3 w-full">
                                    <i class="bi bi-people text-xl {{ request()->routeIs('peminjam.*') ? '' : 'group-hover:scale-110 transition-transform' }}"></i>
                                    <span x-show="!sidebarMini" x-transition class="font-semibold text-sm">Data Peminjam</span>
                                </div>
                            </a>
                        @endif
                    </div>
                @endif
            @endif

            {{-- Divider --}}
            <div class="mx-6">
                <div class="border-t border-gradient-to-r from-transparent via-white/10 to-transparent"></div>
            </div>

            {{-- Other Section --}}
            <div class="px-3 pt-4">
                <p
                    x-show="!sidebarMini"
                    x-transition
                    class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 px-3"
                >
                    Lainnya
                </p>

                {{-- Portal Publik --}}
                <a
                    href="{{ route('landing') }}"
                    target="_blank"
                    class="group flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200 text-slate-300 hover:bg-white/5 hover:text-white relative overflow-hidden"
                    :title="sidebarMini ? 'Portal Publik' : ''"
                >
                    <i class="bi bi-box-arrow-up-right text-xl group-hover:scale-110 group-hover:rotate-12 transition-all"></i>
                    <span x-show="!sidebarMini" x-transition class="font-semibold text-sm">Portal Publik</span>
                </a>

                {{-- User Profile Info (only when sidebar is expanded) --}}
                <div
                    x-show="!sidebarMini"
                    x-transition
                    class="mt-4 p-3 bg-white/5 rounded-xl border border-white/10"
                >
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center text-white font-bold shadow-lg">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name ?? 'User' }}</p>
                            <p class="text-xs text-slate-400 truncate capitalize">
                                <i class="bi bi-shield-check mr-1"></i>
                                {{ Auth::user()->role ?? 'toolskeeper' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Logout --}}
                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button
                        type="submit"
                        class="group w-full flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200 text-red-400 hover:bg-red-500/10 hover:text-red-300 relative overflow-hidden"
                        :title="sidebarMini ? 'Logout' : ''"
                    >
                        <i class="bi bi-box-arrow-right text-xl group-hover:scale-110 group-hover:translate-x-1 transition-all"></i>
                        <span x-show="!sidebarMini" x-transition class="font-semibold text-sm">Logout</span>
                    </button>
                </form>
            </div>
        </nav>

        {{-- Trash Button - Admin Only --}}
        @if(Auth::check() && in_array(Auth::user()->role ?? '', ['admin', 'superadmin']))
            @php $trashCount = \App\Models\Peminjaman::onlyTrashed()->count(); @endphp


            <a
                href="{{ route('peminjaman.trash') }}"
                class="absolute bottom-20 right-3 z-50 group"
                title="Trash Peminjaman"
            >
                <div class="relative w-9 h-9 flex items-center justify-center rounded-xl
                            {{ request()->routeIs('peminjaman.trash')
                                ? 'bg-red-500 shadow-lg shadow-red-500/50'
                                : 'bg-white/5 hover:bg-red-500/20 border border-white/10 hover:border-red-500/40' }}
                            transition-all duration-200">
                    <i class="bi bi-trash3 text-sm
                            {{ request()->routeIs('peminjaman.trash') ? 'text-white' : 'text-slate-400 group-hover:text-red-400' }}
                            transition-colors"></i>

                    @if($trashCount > 0)
                        <span class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-red-500 text-white text-[10px] font-black rounded-full flex items-center justify-center ring-2 ring-slate-900">
                            {{ $trashCount > 9 ? '9+' : $trashCount }}
                        </span>
                    @endif
                </div>
            </a>
        @endif

    </div>

    {{-- Mini Toggle Indicator (Desktop Only) --}}
    <div
        x-show="!sidebarMini"
        class="hidden lg:block absolute -right-3 top-20 z-50"
    >
        <button
            @click="toggleMini()"
            class="w-6 h-6 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full shadow-lg flex items-center justify-center text-white hover:scale-110 transition-transform ring-2 ring-slate-900"
        >
            <i class="bi bi-chevron-left text-xs"></i>
        </button>
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
    class="fixed inset-0 bg-black/60 backdrop-blur-sm z-30 lg:hidden"
></div>

<style>
    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, rgba(59, 130, 246, 0.5), rgba(99, 102, 241, 0.5));
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, rgba(59, 130, 246, 0.7), rgba(99, 102, 241, 0.7));
    }

    /* Smooth Animations */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-10px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    nav a, nav button {
        animation: slideIn 0.3s ease-out;
    }
</style>
