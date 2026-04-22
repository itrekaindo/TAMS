@extends('layouts.app')

@section('title', 'Trash - Data Peminjaman')
@section('page-title', 'Trash Peminjaman')
@section('page-subtitle', 'Data peminjaman yang telah dihapus sementara')

@section('content')
    <div class="space-y-6">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm">
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-blue-600 transition-colors font-medium">
                <i class="bi bi-house-door"></i>
                Dashboard
            </a>
            <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
            <a href="{{ route('peminjaman.index') }}" class="text-gray-500 hover:text-blue-600 transition-colors font-medium">
                Data Peminjaman
            </a>
            <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
            <span class="text-gray-900 font-semibold">Trash</span>
        </nav>

        {{-- Warning Banner --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-red-50 to-orange-50 border border-red-200 rounded-2xl p-5">
            <div class="absolute top-0 right-0 w-32 h-32 bg-red-500/5 rounded-full -mr-16 -mt-16"></div>
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-red-500/30">
                    <i class="bi bi-exclamation-triangle-fill text-white"></i>
                </div>
                <div>
                    <h3 class="font-bold text-red-800 mb-1">Zona Trash — Hanya Admin</h3>
                    <p class="text-sm text-red-600">
                        Data di halaman ini sudah dihapus sementara. Anda dapat <strong>memulihkan</strong> data kembali ke daftar aktif,
                        atau <strong>menghapus permanen</strong> untuk menghilangkan data selamanya beserta semua file terkait.
                        Penghapusan permanen <strong>tidak dapat dibatalkan</strong>.
                    </p>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-lg p-5 flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg shadow-red-500/30">
                    <i class="bi bi-trash3 text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-black text-gray-900">{{ $peminjamans->total() }}</p>
                    <p class="text-xs text-gray-500 font-medium">Total Data Terhapus</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-lg p-5 flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                    <i class="bi bi-arrow-counterclockwise text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-black text-gray-900">{{ $peminjamans->total() }}</p>
                    <p class="text-xs text-gray-500 font-medium">Bisa Dipulihkan</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-lg p-5 flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg shadow-orange-500/30">
                    <i class="bi bi-shield-exclamation text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-black text-gray-900">Permanen</p>
                    <p class="text-xs text-gray-500 font-medium">Tidak Bisa Dibatalkan</p>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-red-50 to-orange-50 px-6 py-5 border-b border-red-100">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-1.5 h-8 bg-gradient-to-b from-red-500 to-orange-500 rounded-full"></div>
                            <h2 class="text-2xl font-black text-gray-900">Data Terhapus</h2>
                        </div>
                        <p class="text-sm text-gray-500 font-medium ml-6">Riwayat peminjaman yang telah dipindahkan ke trash</p>
                    </div>
                    <a href="{{ route('peminjaman.index') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border-2 border-gray-200 text-gray-700 rounded-xl hover:border-blue-400 hover:text-blue-600 transition-all text-sm font-bold">
                        <i class="bi bi-arrow-left"></i>
                        <span>Kembali ke Daftar</span>
                    </a>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                @if ($peminjamans->isEmpty())
                    <div class="text-center py-20">
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl mb-6 shadow-inner">
                            <i class="bi bi-trash3 text-5xl text-gray-300"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Trash Kosong</h3>
                        <p class="text-gray-500 mb-6 max-w-md mx-auto">Tidak ada data peminjaman yang dihapus sementara</p>
                        <a href="{{ route('peminjaman.index') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg transition-all font-semibold">
                            <i class="bi bi-arrow-left"></i>
                            <span>Kembali ke Daftar</span>
                        </a>
                    </div>
                @else
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-red-50/50 border-b border-red-100">
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">Kode</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">Peminjam</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">Alat Dipinjam</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">Tanggal Pinjam</th>
                                <th class="px-6 py-4 text-left text-xs font-black text-gray-600 uppercase tracking-wider">Dihapus Pada</th>
                                <th class="px-6 py-4 text-center text-xs font-black text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-black text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @foreach ($peminjamans as $peminjaman)
                                <tr class="group hover:bg-red-50/20 transition-all duration-300 opacity-80 hover:opacity-100">

                                    {{-- Kode --}}
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                                <i class="bi bi-trash3 text-red-400 text-sm"></i>
                                            </div>
                                            <code class="text-xs font-mono font-bold bg-red-50 px-2.5 py-1.5 rounded-lg text-red-700 border border-red-100">
                                                {{ $peminjaman->kode_peminjaman }}
                                            </code>
                                        </div>
                                    </td>

                                    {{-- Peminjam --}}
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-11 h-11 bg-gradient-to-br from-gray-300 to-gray-400 rounded-xl flex items-center justify-center text-white font-black text-base shadow-md">
                                                {{ strtoupper(substr($peminjaman->nama_lengkap, 0, 1)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-bold text-gray-700 truncate">{{ $peminjaman->nama_lengkap }}</p>
                                                <div class="flex items-center gap-2 mt-1">
                                                    <span class="inline-flex items-center gap-1 text-xs text-gray-400">
                                                        <i class="bi bi-person-badge"></i>
                                                        {{ $peminjaman->nip }}
                                                    </span>
                                                    <span class="text-gray-300">•</span>
                                                    <span class="inline-flex items-center gap-1 text-xs text-gray-400">
                                                        <i class="bi bi-building"></i>
                                                        {{ $peminjaman->departemen }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Alat --}}
                                    <td class="px-6 py-5">
                                        @if ($peminjaman->details && $peminjaman->details->count() > 0)
                                            <div class="space-y-1.5">
                                                @foreach ($peminjaman->details->take(2) as $detail)
                                                    <div class="flex items-center gap-2">
                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-bold rounded-lg bg-gray-100 text-gray-500 border border-gray-200">
                                                            <i class="bi bi-box"></i>
                                                            <span class="max-w-[160px] truncate">{{ $detail->nama_alat }}</span>
                                                        </span>
                                                        <span class="inline-flex items-center px-2 py-1 text-xs font-black rounded-lg bg-gray-100 text-gray-500">
                                                            ×{{ $detail->jumlah }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                                @if ($peminjaman->details->count() > 2)
                                                    <span class="text-xs text-gray-400 font-semibold">
                                                        +{{ $peminjaman->details->count() - 2 }} alat lainnya
                                                    </span>
                                                @endif
                                                <p class="text-xs text-gray-400 font-medium pt-0.5">
                                                    {{ $peminjaman->details->sum('jumlah') }} unit total
                                                </p>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-300 italic">Tidak ada data alat</span>
                                        @endif
                                    </td>

                                    {{-- Tanggal Pinjam --}}
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                                <i class="bi bi-calendar-event text-gray-400 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-600">
                                                    {{ $peminjaman->tanggal_pinjam->format('d M Y') }}
                                                </p>
                                                <p class="text-xs text-gray-400">
                                                    {{ $peminjaman->tanggal_pinjam->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Dihapus Pada --}}
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                                <i class="bi bi-clock-history text-red-400 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-red-600">
                                                    {{ $peminjaman->deleted_at->format('d M Y') }}
                                                </p>
                                                <p class="text-xs text-red-400">
                                                    {{ $peminjaman->deleted_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-5 text-center">
                                        @if ($peminjaman->status === 'dikembalikan')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-black rounded-xl bg-gray-100 text-gray-500">
                                                <i class="bi bi-check-circle"></i>
                                                Dikembalikan
                                            </span>
                                        @elseif ($peminjaman->status === 'sebagian_dikembalikan')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-black rounded-xl bg-gray-100 text-gray-500">
                                                <i class="bi bi-arrow-repeat"></i>
                                                Sebagian
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-black rounded-xl bg-gray-100 text-gray-500">
                                                <i class="bi bi-clock"></i>
                                                Dipinjam
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-5">
                                        <div class="flex items-center justify-end gap-2">

                                            {{-- Lihat Detail --}}
                                            <a href="{{ route('peminjaman.show', $peminjaman->id) }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-bold text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-all hover:shadow-md"
                                                title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            {{-- Restore --}}
                                            <form action="{{ route('peminjaman.restore', $peminjaman->id) }}" method="POST"
                                                onsubmit="return confirm('Pulihkan data peminjaman {{ $peminjaman->kode_peminjaman }}?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-bold text-green-600 bg-green-50 rounded-lg hover:bg-green-100 transition-all hover:shadow-md"
                                                    title="Pulihkan">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </button>
                                            </form>

                                            {{-- Hapus Permanen --}}
                                            <form action="{{ route('peminjaman.permanent-delete', $peminjaman->id) }}" method="POST"
                                                onsubmit="return confirmPermanentDelete('{{ $peminjaman->kode_peminjaman }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-bold text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-all hover:shadow-md"
                                                    title="Hapus Permanen">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            {{-- Pagination --}}
            @if ($peminjamans->hasPages())
                <div class="px-6 py-5 border-t border-gray-100 bg-gray-50/50">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-gray-600 font-medium">
                            Menampilkan
                            <span class="font-black text-gray-900">{{ $peminjamans->firstItem() }}</span>
                            sampai
                            <span class="font-black text-gray-900">{{ $peminjamans->lastItem() }}</span>
                            dari
                            <span class="font-black text-gray-900">{{ $peminjamans->total() }}</span>
                            data terhapus
                        </div>
                        <div>
                            {{ $peminjamans->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function confirmPermanentDelete(kode) {
            return confirm(
                '⚠️ HAPUS PERMANEN\n\n' +
                'Kode: ' + kode + '\n\n' +
                'Tindakan ini akan menghapus data beserta semua file foto dan dokumen terkait.\n' +
                'Data yang dihapus permanen TIDAK BISA dipulihkan kembali.\n\n' +
                'Apakah Anda yakin ingin melanjutkan?'
            );
        }

        // Animate rows on load
        document.querySelectorAll('tbody tr').forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateY(15px)';
            row.style.transition = `all 0.4s ease ${index * 0.05}s`;

            setTimeout(() => {
                row.style.opacity = '0.8';
                row.style.transform = 'translateY(0)';
            }, 50);
        });
    </script>
@endsection
