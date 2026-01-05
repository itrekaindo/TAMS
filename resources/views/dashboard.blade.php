@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan lengkap sistem peminjaman alat')

@section('content')
    <div class="space-y-6">

        {{-- Welcome Section with Glass Morphism --}}
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 p-8 shadow-2xl">
            {{-- Animated Background Pattern --}}
            <div class="absolute inset-0 opacity-10">
                <div
                    class="absolute top-0 -left-4 w-72 h-72 bg-white rounded-full mix-blend-overlay filter blur-xl animate-blob">
                </div>
                <div
                    class="absolute top-0 -right-4 w-72 h-72 bg-white rounded-full mix-blend-overlay filter blur-xl animate-blob animation-delay-2000">
                </div>
                <div
                    class="absolute -bottom-8 left-20 w-72 h-72 bg-white rounded-full mix-blend-overlay filter blur-xl animate-blob animation-delay-4000">
                </div>
            </div>

            <div class="relative z-10 flex items-center justify-between flex-wrap gap-6">
                <div class="flex-1 min-w-[300px]">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="h-1 w-12 bg-white/50 rounded-full"></div>
                        <p class="text-blue-100 text-sm font-medium uppercase tracking-wider">Welcome Back</p>
                    </div>
                    <h1 class="text-4xl lg:text-5xl font-bold text-white mb-3 tracking-tight">
                        Halo, {{ Auth::user()->name ?? 'Admin' }}!
                    </h1>
                    <p class="text-blue-100 text-lg max-w-2xl leading-relaxed">
                        Berikut adalah ringkasan lengkap sistem peminjaman alat Anda hari ini
                    </p>

                    {{-- Quick Stats Mini Cards --}}
                    <div class="mt-6 flex flex-wrap gap-4">
                        <div class="bg-white/10 backdrop-blur-lg rounded-2xl px-4 py-3 border border-white/20">
                            <p class="text-xs text-blue-100 font-medium mb-1">Hari Ini</p>
                            <p class="text-2xl font-bold text-white">{{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-lg rounded-2xl px-4 py-3 border border-white/20">
                            <p class="text-xs text-blue-100 font-medium mb-1">Jam</p>
                            <p class="text-2xl font-bold text-white" id="live-clock">
                                {{ \Carbon\Carbon::now()->format('H:i:s') }}</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-lg rounded-2xl px-4 py-3 border border-white/20">
                            <p class="text-xs text-blue-100 font-medium mb-1">Peminjaman Hari Ini</p>
                            <p class="text-2xl font-bold text-white">{{ $peminjamanHariIni }}</p>
                        </div>
                    </div>
                </div>

                {{-- Decorative Icon --}}
                <div class="hidden lg:block relative">
                    <div
                        class="w-32 h-32 bg-white/10 backdrop-blur-xl rounded-3xl flex items-center justify-center border border-white/20 shadow-2xl transform hover:scale-110 hover:rotate-6 transition-all duration-300">
                        <i class="bi bi-speedometer2 text-7xl text-white drop-shadow-lg"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-400 rounded-full animate-ping"></div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-400 rounded-full"></div>
                </div>
            </div>
        </div>

        {{-- Enhanced Statistics Cards with Dynamic Growth --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Total Alat --}}
            <div
                class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 transform hover:-translate-y-2">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-blue-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                </div>
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-700">
                </div>

                <div class="relative p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="h-1 w-8 bg-blue-500 rounded-full"></div>
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Alat</p>
                            </div>
                            <h3
                                class="text-4xl font-black text-gray-900 mb-1 bg-gradient-to-br from-gray-900 to-gray-600 bg-clip-text text-transparent">
                                {{ $totalAlat }}
                            </h3>
                            <p class="text-sm text-gray-500 font-medium">Unit terdaftar</p>
                        </div>
                        <div class="relative">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-blue-500/50 group-hover:scale-110 group-hover:rotate-12 transition-all duration-500">
                                <i class="bi bi-box-seam text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 text-xs font-semibold">
                        @if ($totalAlatGrowth > 0)
                            <span class="flex items-center gap-1 text-green-600">
                                <i class="bi bi-arrow-up-short"></i>
                                <span>{{ $totalAlatGrowth }}%</span>
                            </span>
                        @elseif($totalAlatGrowth < 0)
                            <span class="flex items-center gap-1 text-red-600">
                                <i class="bi bi-arrow-down-short"></i>
                                <span>{{ abs($totalAlatGrowth) }}%</span>
                            </span>
                        @else
                            <span class="flex items-center gap-1 text-gray-600">
                                <i class="bi bi-dash"></i>
                                <span>0%</span>
                            </span>
                        @endif
                        <span class="text-gray-400">vs bulan lalu</span>
                    </div>
                </div>

                <div
                    class="absolute bottom-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-500 to-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500">
                </div>
            </div>

            {{-- Total Peminjam --}}
            <div
                class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 transform hover:-translate-y-2">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-green-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                </div>
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-green-500/5 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-700">
                </div>

                <div class="relative p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="h-1 w-8 bg-green-500 rounded-full"></div>
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Peminjam</p>
                            </div>
                            <h3
                                class="text-4xl font-black text-gray-900 mb-1 bg-gradient-to-br from-gray-900 to-gray-600 bg-clip-text text-transparent">
                                {{ $totalPeminjam }}
                            </h3>
                            <p class="text-sm text-gray-500 font-medium">Terdaftar aktif</p>
                        </div>
                        <div class="relative">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-green-500/50 group-hover:scale-110 group-hover:rotate-12 transition-all duration-500">
                                <i class="bi bi-people text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 text-xs font-semibold">
                        @if ($totalPeminjamGrowth > 0)
                            <span class="flex items-center gap-1 text-green-600">
                                <i class="bi bi-arrow-up-short"></i>
                                <span>{{ $totalPeminjamGrowth }}%</span>
                            </span>
                        @elseif($totalPeminjamGrowth < 0)
                            <span class="flex items-center gap-1 text-red-600">
                                <i class="bi bi-arrow-down-short"></i>
                                <span>{{ abs($totalPeminjamGrowth) }}%</span>
                            </span>
                        @else
                            <span class="flex items-center gap-1 text-gray-600">
                                <i class="bi bi-dash"></i>
                                <span>0%</span>
                            </span>
                        @endif
                        <span class="text-gray-400">vs bulan lalu</span>
                    </div>
                </div>

                <div
                    class="absolute bottom-0 left-0 right-0 h-1.5 bg-gradient-to-r from-green-500 to-green-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500">
                </div>
            </div>

            {{-- Total Peminjaman --}}
            <div
                class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 transform hover:-translate-y-2">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-purple-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                </div>
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-purple-500/5 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-700">
                </div>

                <div class="relative p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="h-1 w-8 bg-purple-500 rounded-full"></div>
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Transaksi</p>
                            </div>
                            <h3
                                class="text-4xl font-black text-gray-900 mb-1 bg-gradient-to-br from-gray-900 to-gray-600 bg-clip-text text-transparent">
                                {{ $totalPeminjaman }}
                            </h3>
                            <p class="text-sm text-gray-500 font-medium">Total peminjaman</p>
                        </div>
                        <div class="relative">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-purple-500/50 group-hover:scale-110 group-hover:rotate-12 transition-all duration-500">
                                <i class="bi bi-journal-check text-white text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 text-xs font-semibold">
                        @if ($totalPeminjamanGrowth > 0)
                            <span class="flex items-center gap-1 text-green-600">
                                <i class="bi bi-arrow-up-short"></i>
                                <span>{{ $totalPeminjamanGrowth }}%</span>
                            </span>
                        @elseif($totalPeminjamanGrowth < 0)
                            <span class="flex items-center gap-1 text-red-600">
                                <i class="bi bi-arrow-down-short"></i>
                                <span>{{ abs($totalPeminjamanGrowth) }}%</span>
                            </span>
                        @else
                            <span class="flex items-center gap-1 text-gray-600">
                                <i class="bi bi-dash"></i>
                                <span>0%</span>
                            </span>
                        @endif
                        <span class="text-gray-400">vs bulan lalu</span>
                    </div>
                </div>

                <div
                    class="absolute bottom-0 left-0 right-0 h-1.5 bg-gradient-to-r from-purple-500 to-purple-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500">
                </div>
            </div>

            {{-- Peminjaman Aktif --}}
            <div
                class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 transform hover:-translate-y-2">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-orange-500/5 to-orange-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                </div>
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-orange-500/5 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-700">
                </div>

                <div class="relative p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="h-1 w-8 bg-orange-500 rounded-full"></div>
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Aktif</p>
                            </div>
                            <h3
                                class="text-4xl font-black text-gray-900 mb-1 bg-gradient-to-br from-gray-900 to-gray-600 bg-clip-text text-transparent">
                                {{ $peminjamanAktif }}
                            </h3>
                            <p class="text-sm text-gray-500 font-medium">Sedang dipinjam</p>
                        </div>
                        <div class="relative">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-orange-500/50 group-hover:scale-110 group-hover:rotate-12 transition-all duration-500">
                                <i class="bi bi-hourglass-split text-white text-2xl"></i>
                            </div>
                            @if ($peminjamanTerlambat > 0)
                                <div class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-2 text-xs font-semibold">
                        @if ($peminjamanTerlambat > 0)
                            <span class="flex items-center gap-1 text-red-600">
                                <i class="bi bi-exclamation-circle"></i>
                                <span>{{ $peminjamanTerlambat }} Peminjaman Terlambat</span>
                            </span>
                        @else
                            <span class="flex items-center gap-1 text-green-600">
                                <i class="bi bi-check-circle"></i>
                                <span>Semua tepat waktu</span>
                            </span>
                        @endif
                    </div>
                </div>

                <div
                    class="absolute bottom-0 left-0 right-0 h-1.5 bg-gradient-to-r from-orange-500 to-orange-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500">
                </div>
            </div>
        </div>

        {{-- Recent Transactions Table --}}
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-8 py-6 border-b border-gray-100">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-1.5 h-8 bg-gradient-to-b from-blue-600 to-indigo-600 rounded-full"></div>
                            <h3 class="font-black text-2xl text-gray-900">Peminjaman Terbaru</h3>
                        </div>
                        <p class="text-sm text-gray-500 font-medium ml-6">10 transaksi terakhir dalam sistem</p>
                    </div>
                    <a href="{{ route('peminjaman.index') }}"
                        class="group flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold text-sm hover:shadow-lg hover:shadow-blue-500/50 transition-all duration-300 hover:-translate-y-0.5">
                        Lihat Semua
                        <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">#
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">
                                Peminjam</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">Alat
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">
                                Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">
                                Status</th>
                            <th class="px-8 py-4 text-right text-xs font-black text-gray-600 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-50">
                        @forelse ($peminjamanTerbaru as $index => $item)
                            <tr
                                class="group hover:bg-gradient-to-r hover:from-blue-50/30 hover:to-indigo-50/30 transition-all duration-300">
                                <td class="px-8 py-5">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                                        <span class="text-sm font-black text-gray-600">{{ $index + 1 }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="relative">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-lg shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                {{ strtoupper(substr($item->nama_lengkap ?? 'U', 0, 1)) }}
                                            </div>
                                            <div
                                                class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white">
                                            </div>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-gray-900 truncate text-base">
                                                {{ $item->nama_lengkap ?? '-' }}</p>
                                            <p class="text-sm text-gray-500 truncate font-medium">
                                                {{ $item->departemen ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    @if ($item->details && $item->details->count() > 0)
                                        <div class="space-y-1">
                                            @foreach ($item->details->take(2) as $detail)
                                                <div class="flex items-center gap-2">
                                                    <span
                                                        class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium rounded bg-blue-50 text-blue-700">
                                                        <i class="bi bi-box"></i>
                                                        {{ Str::limit($detail->nama_alat, 20) }}
                                                    </span>
                                                    <span class="text-xs text-gray-500">×{{ $detail->jumlah }}</span>
                                                </div>
                                            @endforeach
                                            @if ($item->details->count() > 2)
                                                <p class="text-xs text-gray-500">+{{ $item->details->count() - 2 }} alat
                                                    lainnya</p>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-400 mt-1">Total: {{ $item->details->sum('jumlah') }}
                                            unit</p>
                                    @else
                                        <p class="text-sm text-gray-500">Tidak ada data alat</p>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">
                                            {{ $item->tanggal_pinjam?->format('d M Y') ?? '-' }}</p>
                                        <p class="text-xs text-gray-500 font-medium">
                                            {{ $item->tanggal_pinjam?->diffForHumans() ?? '-' }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    @if ($item->status === 'dikembalikan')
                                        <span
                                            class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-black rounded-xl bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg shadow-green-500/30">
                                            <i class="bi bi-check-circle-fill text-sm"></i>
                                            Dikembalikan
                                        </span>
                                    @elseif($item->isLate())
                                        <span
                                            class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-black rounded-xl bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg shadow-red-500/30 animate-pulse">
                                            <i class="bi bi-exclamation-circle-fill text-sm"></i>
                                            Terlambat
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-black rounded-xl bg-gradient-to-r from-yellow-400 to-orange-400 text-white shadow-lg shadow-yellow-500/30">
                                            <i class="bi bi-clock-fill text-sm"></i>
                                            Dipinjam
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <a href="{{ route('peminjaman.show', $item->id) }}"
                                        class="group/link inline-flex items-center gap-2 px-4 py-2 text-blue-600 hover:text-white font-bold text-sm rounded-lg hover:bg-gradient-to-r hover:from-blue-600 hover:to-indigo-600 transition-all duration-300 hover:shadow-lg">
                                        Detail
                                        <i
                                            class="bi bi-arrow-right group-hover/link:translate-x-1 transition-transform"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl flex items-center justify-center mb-6 shadow-inner">
                                            <i class="bi bi-inbox text-5xl text-gray-400"></i>
                                        </div>
                                        <h4 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Data</h4>
                                        <p class="text-sm text-gray-500 font-medium max-w-md">Data peminjaman akan muncul
                                            di sini ketika ada transaksi baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Bottom Grid: Quick Actions, Status Alat, Portal Publik --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Quick Actions --}}
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-gray-50 to-yellow-50 px-6 py-5 border-b border-gray-100">
                    <h3 class="font-black text-xl text-gray-900 flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="bi bi-lightning-charge-fill text-white text-xl"></i>
                        </div>
                        Quick Actions
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <a href="{{ route('peminjaman.create') }}"
                        class="group relative flex items-center gap-4 p-5 rounded-2xl bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 text-white hover:shadow-2xl hover:shadow-blue-500/40 transition-all duration-500 overflow-hidden transform hover:scale-[1.02]">
                        <div
                            class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform duration-500">
                        </div>
                        <div
                            class="relative w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center group-hover:rotate-12 transition-transform duration-500 shadow-lg">
                            <i class="bi bi-plus-circle text-3xl"></i>
                        </div>
                        <div class="relative flex-1">
                            <p class="font-black text-lg mb-0.5">Peminjaman Baru</p>
                            <p class="text-sm text-blue-100 font-medium">Buat transaksi peminjaman</p>
                        </div>
                        <i
                            class="bi bi-arrow-right relative text-2xl group-hover:translate-x-2 transition-transform duration-300"></i>
                    </a>

                    <a href="{{ route('alat.create') }}"
                        class="group relative flex items-center gap-4 p-5 rounded-2xl border-2 border-gray-200 hover:border-blue-500 hover:bg-gradient-to-br hover:from-blue-50 hover:to-indigo-50 transition-all duration-500 overflow-hidden transform hover:scale-[1.02] hover:shadow-xl">
                        <div
                            class="relative w-14 h-14 bg-gray-100 group-hover:bg-gradient-to-br group-hover:from-blue-500 group-hover:to-indigo-600 rounded-xl flex items-center justify-center transition-all duration-500 group-hover:rotate-12 shadow-lg">
                            <i
                                class="bi bi-box-seam text-3xl text-gray-600 group-hover:text-white transition-colors duration-500"></i>
                        </div>
                        <div class="relative flex-1">
                            <p class="font-black text-lg text-gray-900 mb-0.5">Tambah Alat</p>
                            <p class="text-sm text-gray-500 font-medium">Daftarkan alat baru</p>
                        </div>
                        <i
                            class="bi bi-arrow-right text-2xl text-gray-400 group-hover:text-blue-600 group-hover:translate-x-2 transition-all duration-300"></i>
                    </a>

                    <a href="{{ route('alat.import') }}"
                        class="group relative flex items-center gap-4 p-5 rounded-2xl border-2 border-gray-200 hover:border-blue-500 hover:bg-gradient-to-br hover:from-blue-50 hover:to-indigo-50 transition-all duration-500 overflow-hidden transform hover:scale-[1.02] hover:shadow-xl">
                        <div
                            class="relative w-14 h-14 bg-gray-100 group-hover:bg-gradient-to-br group-hover:from-blue-500 group-hover:to-indigo-600 rounded-xl flex items-center justify-center transition-all duration-500 group-hover:rotate-12 shadow-lg">
                            <i
                                class="bi bi-cloud-upload text-3xl text-gray-600 group-hover:text-white transition-colors duration-500"></i>
                        </div>
                        <div class="relative flex-1">
                            <p class="font-black text-lg text-gray-900 mb-0.5">Import Data Alat</p>
                            <p class="text-sm text-gray-500 font-medium">Import data alat dari Template Excel</p>
                        </div>
                        <i
                            class="bi bi-arrow-right text-2xl text-gray-400 group-hover:text-green-600 group-hover:translate-x-2 transition-all duration-300"></i>
                    </a>
                </div>
            </div>

            {{-- Status Alat --}}
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-gray-50 to-purple-50 px-6 py-5 border-b border-gray-100">
                    <h3 class="font-black text-xl text-gray-900 flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="bi bi-bar-chart-fill text-white text-xl"></i>
                        </div>
                        Status Alat
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    {{-- Tersedia --}}
                    <div class="group">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-black text-gray-700 flex items-center gap-2">
                                <div class="w-3 h-3 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full"></div>
                                Tersedia
                            </span>
                            <span
                                class="text-lg font-black text-green-600 bg-green-50 px-3 py-1 rounded-xl">{{ $alatTersedia }}
                                unit</span>
                        </div>
                        <div class="relative w-full bg-gray-100 rounded-full h-4 overflow-hidden shadow-inner">
                            <div class="absolute inset-0 bg-gradient-to-r from-green-400 via-green-500 to-emerald-500 h-4 rounded-full transition-all duration-1000 ease-out shadow-lg shadow-green-500/50 group-hover:shadow-green-500/70"
                                style="width: {{ $persenTersedia }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 font-bold mt-2 flex items-center gap-2">
                            <span
                                class="bg-green-100 text-green-700 px-2 py-0.5 rounded-lg">{{ number_format($persenTersedia, 1) }}%</span>
                            dari total alat
                        </p>
                    </div>

                    {{-- Dipinjam --}}
                    <div class="group">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-black text-gray-700 flex items-center gap-2">
                                <div
                                    class="w-3 h-3 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-full animate-pulse">
                                </div>
                                Dipinjam
                            </span>
                            <span
                                class="text-lg font-black text-orange-600 bg-orange-50 px-3 py-1 rounded-xl">{{ $alatDipinjam }}
                                unit</span>
                        </div>
                        <div class="relative w-full bg-gray-100 rounded-full h-4 overflow-hidden shadow-inner">
                            <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 via-orange-500 to-orange-600 h-4 rounded-full transition-all duration-1000 ease-out shadow-lg shadow-orange-500/50 group-hover:shadow-orange-500/70"
                                style="width: {{ $persenDipinjam }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 font-bold mt-2 flex items-center gap-2">
                            <span
                                class="bg-orange-100 text-orange-700 px-2 py-0.5 rounded-lg">{{ number_format($persenDipinjam, 1) }}%</span>
                            dari total alat
                        </p>
                    </div>

                    {{-- Kondisi Alat --}}
                    <div class="pt-6 border-t-2 border-gray-100">
                        <p class="text-sm font-black text-gray-700 mb-4 flex items-center gap-2">
                            <i class="bi bi-tools text-purple-500"></i>
                            Kondisi Alat
                        </p>
                        <div class="space-y-3">
                            <div
                                class="flex items-center justify-between p-3 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 border border-green-100 group hover:shadow-md transition-all duration-300">
                                <span class="flex items-center gap-3 font-bold text-gray-700">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <i class="bi bi-check-circle-fill text-white"></i>
                                    </div>
                                    Baik
                                </span>
                                <span class="text-2xl font-black text-green-700">{{ $alatBaik }}</span>
                            </div>
                            <div
                                class="flex items-center justify-between p-3 rounded-xl bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-100 group hover:shadow-md transition-all duration-300">
                                <span class="flex items-center gap-3 font-bold text-gray-700">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <i class="bi bi-exclamation-circle-fill text-white"></i>
                                    </div>
                                    Rusak
                                </span>
                                <span class="text-2xl font-black text-orange-700">{{ $alatRusak }}</span>
                            </div>
                            <div
                                class="flex items-center justify-between p-3 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 group hover:shadow-md transition-all duration-300">
                                <span class="flex items-center gap-3 font-bold text-gray-700">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <i class="bi bi-tools text-white"></i>
                                    </div>
                                    Maintenance
                                </span>
                                <span class="text-2xl font-black text-blue-700">{{ $alatMaintenance }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Portal Publik Card --}}
            <div
                class="relative bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 rounded-3xl p-8 shadow-2xl overflow-hidden border border-white/20">
                {{-- Animated Background --}}
                <div class="absolute inset-0 opacity-20">
                    <div
                        class="absolute top-0 left-0 w-40 h-40 bg-white rounded-full mix-blend-overlay filter blur-xl animate-blob">
                    </div>
                    <div
                        class="absolute bottom-0 right-0 w-40 h-40 bg-white rounded-full mix-blend-overlay filter blur-xl animate-blob animation-delay-2000">
                    </div>
                </div>

                <div class="relative z-10">
                    <div class="flex items-start gap-4 mb-6">
                        <div
                            class="w-16 h-16 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center flex-shrink-0 shadow-xl border border-white/30">
                            <i class="bi bi-globe2 text-white text-3xl"></i>
                        </div>
                        <div>
                            <h4 class="font-black text-2xl text-white mb-2">Portal Publik</h4>
                            <p class="text-blue-100 font-medium leading-relaxed">
                                Pengguna dapat mengakses form peminjaman dan pengembalian melalui portal publik
                            </p>
                        </div>
                    </div>

                    {{-- Stats Mini --}}
                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/20">
                            <p class="text-xs text-blue-100 mb-1">Total Alat</p>
                            <p class="text-2xl font-black text-white">{{ $totalAlatUnit }}</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/20">
                            <p class="text-xs text-blue-100 mb-1">Tersedia</p>
                            <p class="text-2xl font-black text-white">{{ $alatTersedia }}</p>
                        </div>
                    </div>

                    <a href="{{ route('landing') }}" target="_blank"
                        class="group inline-flex items-center gap-3 px-6 py-3.5 bg-white text-blue-600 rounded-xl font-black hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                        <i class="bi bi-box-arrow-up-right text-xl"></i>
                        Buka Portal Publik
                        <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- Custom Animations & Scripts --}}
    <style>
        @keyframes blob {

            0%,
            100% {
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

        /* Progress Bar Animation on Load */
        @keyframes progressLoad {
            from {
                width: 0%;
            }
        }

        .animate-progress {
            animation: progressLoad 1.5s ease-out;
        }
    </style>

    {{-- Live Clock & Animations Script --}}
    <script>
        // Live Clock Update
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const clockElement = document.getElementById('live-clock');
            if (clockElement) {
                clockElement.textContent = `${hours}:${minutes}:${seconds}`;
            }
        }

        // Update clock every second
        setInterval(updateClock, 1000);
        updateClock(); // Initial call

        // Add animation class to progress bars on load
        document.addEventListener('DOMContentLoaded', function() {
            const progressBars = document.querySelectorAll(
                '.bg-gradient-to-r.from-green-400, .bg-gradient-to-r.from-yellow-400');
            progressBars.forEach(bar => {
                bar.classList.add('animate-progress');
            });
        });
    </script>
@endsection
