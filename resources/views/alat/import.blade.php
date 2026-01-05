@extends('layouts.app')

@section('title', 'Import Data Alat')
@section('page-title', 'Import Data Alat')
@section('page-subtitle', 'Import data alat dari file Excel')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm">
        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-blue-600 transition-colors font-medium">
            <i class="bi bi-house-door"></i>
            Dashboard
        </a>
        <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
        <a href="{{ route('alat.index') }}" class="text-gray-500 hover:text-blue-600 transition-colors font-medium">
            Data Alat
        </a>
        <i class="bi bi-chevron-right text-gray-400 text-xs"></i>
        <span class="text-gray-900 font-semibold">Import Data</span>
    </nav>

    {{-- Instruksi --}}
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg p-6">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                    <i class="bi bi-info-circle text-white text-2xl"></i>
                </div>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900 mb-3">Panduan Import Data</h3>
                <ol class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-start gap-2">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                        <span>Download template Excel dengan klik tombol "Download Template" di bawah</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                        <span>Isi data sesuai kolom yang tersedia (jangan mengubah nama kolom header)</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                        <span>Simpan file dan upload menggunakan form di bawah</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold">4</span>
                        <span>Jika kode_alat sudah ada, data akan diupdate. Jika belum ada, akan ditambahkan sebagai data baru</span>
                    </li>
                </ol>
            </div>
        </div>
    </div>

    {{-- Kolom yang Wajib dan Opsional --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="bi bi-check-circle text-green-600"></i>
                Kolom Wajib Diisi
            </h3>
            <ul class="space-y-2 text-sm">
                <li class="flex items-center gap-2">
                    <i class="bi bi-dot text-green-600 text-2xl"></i>
                    <code class="bg-green-50 px-2 py-1 rounded text-green-700 font-mono">kode_alat</code>
                </li>
                <li class="flex items-center gap-2">
                    <i class="bi bi-dot text-green-600 text-2xl"></i>
                    <code class="bg-green-50 px-2 py-1 rounded text-green-700 font-mono">nama_alat</code>
                </li>
                <li class="flex items-center gap-2">
                    <i class="bi bi-dot text-green-600 text-2xl"></i>
                    <code class="bg-green-50 px-2 py-1 rounded text-green-700 font-mono">jumlah_total</code>
                </li>
            </ul>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="bi bi-dash-circle text-gray-600"></i>
                Kolom Opsional
            </h3>
            <ul class="space-y-2 text-sm">
                <li class="flex items-center gap-2">
                    <i class="bi bi-dot text-gray-600 text-2xl"></i>
                    <code class="bg-gray-50 px-2 py-1 rounded text-gray-700 font-mono">deskripsi</code>
                </li>
                <li class="flex items-center gap-2">
                    <i class="bi bi-dot text-gray-600 text-2xl"></i>
                    <code class="bg-gray-50 px-2 py-1 rounded text-gray-700 font-mono">jumlah_tersedia</code>
                    <span class="text-xs text-gray-500">(default = jumlah_total)</span>
                </li>
                <li class="flex items-center gap-2">
                    <i class="bi bi-dot text-gray-600 text-2xl"></i>
                    <code class="bg-gray-50 px-2 py-1 rounded text-gray-700 font-mono">kondisi</code>
                    <span class="text-xs text-gray-500">(default = baik)</span>
                </li>
                <li class="flex items-center gap-2">
                    <i class="bi bi-dot text-gray-600 text-2xl"></i>
                    <code class="bg-gray-50 px-2 py-1 rounded text-gray-700 font-mono">kategori</code>
                </li>
                <li class="flex items-center gap-2">
                    <i class="bi bi-dot text-gray-600 text-2xl"></i>
                    <code class="bg-gray-50 px-2 py-1 rounded text-gray-700 font-mono">lokasi</code>
                </li>
            </ul>
        </div>
    </div>

    {{-- Nilai Kondisi yang Valid --}}
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <p class="text-sm text-gray-700">
            <strong>Nilai untuk kolom "kondisi":</strong>
            <code class="bg-yellow-100 px-2 py-0.5 rounded mx-1">baik</code>,
            <code class="bg-yellow-100 px-2 py-0.5 rounded mx-1">rusak_ringan</code>,
            <code class="bg-yellow-100 px-2 py-0.5 rounded mx-1">rusak_berat</code>,
            <code class="bg-yellow-100 px-2 py-0.5 rounded mx-1">maintenance</code>
        </p>
    </div>

    {{-- Download Template --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Download Template</h3>
                <p class="text-sm text-gray-600">Template Excel sudah berisi contoh data dan format yang benar</p>
            </div>
            <a href="{{ route('alat.template') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:shadow-lg hover:shadow-green-500/50 transition-all font-bold">
                <i class="bi bi-download text-lg"></i>
                Download Template
            </a>
        </div>
    </div>

    {{-- Form Upload --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-6 py-5 border-b border-gray-100">
            <h3 class="text-xl font-black text-gray-900 flex items-center gap-2">
                <i class="bi bi-cloud-upload text-blue-600"></i>
                Upload File Excel
            </h3>
        </div>

        <form action="{{ route('alat.import') }}" method="POST" enctype="multipart/form-data" id="formImport">
            @csrf
            <div class="p-6 space-y-6">
                <div>
                    <label for="file" class="block text-sm font-bold text-gray-700 mb-2">
                        Pilih File Excel <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="file"
                               name="file"
                               id="file"
                               accept=".xlsx,.xls"
                               class="block w-full text-sm text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-gray-50 focus:outline-none focus:border-blue-500 p-3"
                               required>
                        @error('file')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <p class="mt-2 text-xs text-gray-500">
                        <i class="bi bi-info-circle"></i>
                        Format: Excel (.xlsx, .xls). Maksimal 2MB
                    </p>
                </div>

                {{-- Preview File Name --}}
                <div id="filePreview" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                            <i class="bi bi-file-earmark-excel text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900" id="fileName"></p>
                            <p class="text-xs text-gray-600" id="fileSize"></p>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                    <button type="submit"
                            class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg hover:shadow-blue-500/50 transition-all font-bold">
                        <i class="bi bi-upload text-lg"></i>
                        Upload & Import Data
                    </button>
                    <a href="{{ route('alat.index') }}"
                       class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-bold">
                        <i class="bi bi-x-circle"></i>
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Preview file yang dipilih
    document.getElementById('file').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('filePreview');

        if (file) {
            document.getElementById('fileName').textContent = file.name;
            document.getElementById('fileSize').textContent = formatFileSize(file.size);
            preview.classList.remove('hidden');
        } else {
            preview.classList.add('hidden');
        }
    });

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    // Loading state saat submit
    document.getElementById('formImport').addEventListener('submit', function() {
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-hourglass-split animate-spin text-lg"></i> Sedang mengimport...';
    });
</script>
@endsection
