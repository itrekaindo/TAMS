<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BeritaAcaraController;

// Auth routes (login, register, dll)
require __DIR__ . '/auth.php';

// Landing page
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// Public Routes - Peminjaman
Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
Route::get('/api/alat/search', [PeminjamanController::class, 'searchAlat'])->name('alat.search');

// Public Routes - Pengembalian
Route::get('/pengembalian', [PeminjamanController::class, 'cariPeminjaman'])->name('pengembalian.cari');
Route::post('/pengembalian/cari', [PeminjamanController::class, 'prosesCariPeminjaman'])->name('pengembalian.proses-cari');
Route::get('/pengembalian/{kode}', [PeminjamanController::class, 'formPengembalian'])->name('pengembalian.form');
Route::post('/pengembalian/{id}/submit', [PeminjamanController::class, 'submitPengembalian'])->name('pengembalian.submit');

Route::post('/pengembalian/{peminjaman}/generate-berita-acara', [BeritaAcaraController::class, 'generateBeritaAcara'])->name('pengembalian.generate-ba');
Route::get('/pengembalian/{peminjaman}/preview-berita-acara', [BeritaAcaraController::class, 'previewBeritaAcara'])->name('pengembalian.preview-ba');
Route::get('/pengembalian/{kode_peminjaman}/view-pdf', [BeritaAcaraController::class, 'viewPDF'])->name('pengembalian.view-pdf');

// Routes untuk user yang sudah login
Route::middleware(['auth'])->group(function () {

    // Dashboard - Accessible by ALL authenticated users
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes - Accessible by ALL authenticated users
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes untuk Tools Keeper & Admin - Shared Routes
    Route::middleware(['role:toolskeeper,admin'])->group(function () {
        // Dashboard detail
        Route::get('/dashboard/alat-by-kondisi/{kondisi}', [DashboardController::class, 'getAlatByKondisi'])->name('dashboard.alat-by-kondisi');

        // Peminjaman - Full CRUD
        Route::resource('peminjaman', PeminjamanController::class)->except(['create', 'store']);
        Route::get('/peminjaman/{id}/items', [PeminjamanController::class, 'getItems'])->name('peminjaman.items');

        // Kembalikan peminjaman
        Route::get('peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
        Route::post('peminjaman/{id}/proses-kembalikan', [PeminjamanController::class, 'prosesKembalikan'])->name('peminjaman.proses-kembalikan');

        // Histori pengembalian
        Route::get('/peminjaman/{id}/histori-pengembalian', [PeminjamanController::class, 'historiPengembalian'])
            ->name('peminjaman.histori-pengembalian');

        // Extend/Perpanjang peminjaman
        Route::put('/peminjaman/{id}/extend', [PeminjamanController::class, 'extendPeminjaman'])->name('peminjaman.extend');

        // Peminjam - View & Create (tidak bisa delete)
        Route::resource('peminjam', PeminjamController::class)->except(['destroy']);



        // API Routes
        Route::prefix('api')->group(function () {
            Route::get('alat/{id}', [PeminjamanController::class, 'getAlatDetail'])->name('api.alat.detail');
            Route::get('peminjam/{id}', [PeminjamController::class, 'getPeminjamDetail'])->name('api.peminjam.detail');
        });
    });

    // Routes khusus Admin ONLY
    Route::middleware(['role:admin'])->group(function () {
        // Import Alat
        Route::get('/alat/import', [AlatController::class, 'importForm'])->name('alat.import.form');
        Route::post('/alat/import', [AlatController::class, 'import'])->name('alat.import');
        Route::get('/alat/template', [AlatController::class, 'downloadTemplate'])->name('alat.template');

        // Alat - Full CRUD
        Route::resource('alat', AlatController::class)->only(['index', 'show']);
        Route::get('/alat/create', [AlatController::class, 'create'])->name('alat.create');
        Route::post('/alat', [AlatController::class, 'store'])->name('alat.store');
        Route::get('/alat/{alat}/edit', [AlatController::class, 'edit'])->name('alat.edit');
        Route::put('/alat/{alat}', [AlatController::class, 'update'])->name('alat.update');
        Route::delete('/alat/{alat}', [AlatController::class, 'destroy'])->name('alat.destroy');

        // Adjust Stock
        Route::post('alat/{alat}/adjust-stock', [AlatController::class, 'adjustStock'])->name('alat.adjust-stock');

        // Delete Peminjam
        Route::delete('peminjam/{peminjam}', [PeminjamController::class, 'destroy'])->name('peminjam.destroy');
    });
});
