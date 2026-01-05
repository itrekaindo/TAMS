{{-- resources/views/alat/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Alat - ' . $alat->kode_alat)
@section('page-title', 'Detail Alat')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Tombol Aksi Atas -->
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('alat.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('alat.edit', $alat) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
            <i class="bi bi-pencil"></i> Edit
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informasi Alat -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Info Utama -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <i class="bi bi-info-circle text-blue-600"></i> Informasi Alat
                    </h2>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Kode Alat</dt>
                            <dd class="mt-1 text-lg font-mono font-bold text-blue-700">{{ $alat->kode_alat }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama Alat</dt>
                            <dd class="mt-1 font-medium text-gray-800">{{ $alat->nama_alat }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Kategori</dt>
                            <dd class="mt-1">
                                @if($alat->kategori)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $alat->kategori }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Lokasi</dt>
                            <dd class="mt-1 text-gray-700">{{ $alat->lokasi ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                            <dd class="mt-1 text-gray-700 whitespace-pre-line">{{ $alat->deskripsi ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Kondisi</dt>
                            <dd class="mt-1">
                                @php
                                    $kondisiMap = [
                                        'baik' => ['label' => 'Baik', 'color' => 'bg-green-100 text-green-800'],
                                        'rusak_ringan' => ['label' => 'Rusak Ringan', 'color' => 'bg-yellow-100 text-yellow-800'],
                                        'rusak_berat' => ['label' => 'Rusak Berat', 'color' => 'bg-red-100 text-red-800'],
                                        'maintenance' => ['label' => 'Maintenance', 'color' => 'bg-blue-100 text-blue-800'],
                                    ];
                                    $kondisi = $kondisiMap[$alat->kondisi] ?? ['label' => 'Tidak Diketahui', 'color' => 'bg-gray-100 text-gray-800'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $kondisi['color'] }}">
                                    {{ $kondisi['label'] }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Stok -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <i class="bi bi-box text-gray-600"></i> Stok
                    </h2>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-sm text-gray-600">Total</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $alat->jumlah_total }}</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4 text-center">
                            <p class="text-sm text-green-700">Tersedia</p>
                            <p class="text-2xl font-bold text-green-800 mt-1">{{ $alat->jumlah_tersedia }}</p>
                        </div>
                        <div class="bg-amber-50 rounded-lg p-4 text-center">
                            <p class="text-sm text-amber-700">Dipinjam</p>
                            <p class="text-2xl font-bold text-amber-800 mt-1">{{ $alat->jumlah_total - $alat->jumlah_tersedia }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Peminjaman -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <i class="bi bi-clock-history text-gray-600"></i> Riwayat Peminjaman (10 Terakhir)
                    </h2>
                </div>
                <div class="p-6">
                    @if($alat->peminjamans->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-50 text-gray-600">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Kode</th>
                                        <th class="px-4 py-2 text-left">Peminjam</th>
                                        <th class="px-4 py-2 text-center">Jumlah</th>
                                        <th class="px-4 py-2 text-left">Tanggal</th>
                                        <th class="px-4 py-2 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($alat->peminjamans as $peminjaman)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2">
                                                <a href="{{ route('peminjaman.show', $peminjaman->id) }}" class="text-blue-600 hover:underline font-mono">
                                                    {{ $peminjaman->kode_peminjaman }}
                                                </a>
                                            </td>
                                            <td class="px-4 py-2">
                                                <div class="font-medium">{{ $peminjaman->peminjam->nama_lengkap }}</div>
                                                <div class="text-sm text-gray-500">{{ $peminjaman->peminjam->departemen }}</div>
                                            </td>
                                            <td class="px-4 py-2 text-center">{{ $peminjaman->jumlah }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-600">
                                                {{ $peminjaman->tanggal_pinjam->isoFormat('D MMM Y') }}
                                            </td>
                                            <td class="px-4 py-2 text-center">
                                                @if($peminjaman->status === 'dipinjam')
                                                    @if(method_exists($peminjaman, 'isLate') && $peminjaman->isLate())
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            Terlambat
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            Dipinjam
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Dikembalikan
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="bi bi-inbox text-3xl mb-2 block"></i>
                            Belum ada riwayat peminjaman
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Kanan: Statistik & Info Tambahan -->
        <div class="space-y-6">
            <!-- Statistik -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <i class="bi bi-bar-chart text-gray-600"></i> Statistik Peminjaman
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Total -->
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Total Peminjaman</span>
                            <span class="font-medium text-gray-800">{{ $totalPeminjaman }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 100%"></div>
                        </div>
                    </div>

                    <!-- Sedang Dipinjam -->
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Sedang Dipinjam</span>
                            <span class="font-medium text-amber-700">{{ $sedangDipinjam }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-amber-500 h-2 rounded-full" style="width: {{ $totalPeminjaman ? ($sedangDipinjam / $totalPeminjaman * 100) : 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Sudah Dikembalikan -->
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Sudah Dikembalikan</span>
                            <span class="font-medium text-green-700">{{ $sudahDikembalikan }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalPeminjaman ? ($sudahDikembalikan / $totalPeminjaman * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <i class="bi bi-info-square text-gray-600"></i> Informasi Tambahan
                    </h2>
                </div>
                <div class="p-6 text-sm text-gray-600 space-y-3">
                    <div class="flex items-start gap-2">
                        <i class="bi bi-calendar-plus text-gray-500 mt-0.5"></i>
                        <span>
                            Ditambahkan:<br>
                            <strong class="text-gray-800">{{ $alat->created_at->isoFormat('D MMMM Y, HH:mm') }}</strong>
                        </span>
                    </div>
                    <div class="flex items-start gap-2">
                        <i class="bi bi-calendar-event text-gray-500 mt-0.5"></i>
                        <span>
                            Diupdate:<br>
                            <strong class="text-gray-800">{{ $alat->updated_at->isoFormat('D MMMM Y, HH:mm') }}</strong>
                        </span>
                    </div>

                    @if($alat->jumlah_tersedia == 0)
                        <div class="p-3 bg-amber-50 border border-amber-200 rounded-lg">
                            <div class="flex items-start gap-2">
                                <i class="bi bi-exclamation-triangle-fill text-amber-700 mt-0.5"></i>
                                <div>
                                    <strong class="text-amber-800">Stok Habis!</strong><br>
                                    <span class="text-amber-700">Semua unit sedang dipinjam.</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($alat->kondisi !== 'baik')
                        <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-start gap-2">
                                <i class="bi bi-tools text-red-700 mt-0.5"></i>
                                <div>
                                    <strong class="text-red-800">Perlu Perhatian!</strong><br>
                                    <span class="text-red-700">Kondisi alat: {{ \App\Models\Alat::kondisiOptions()[$alat->kondisi] }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
