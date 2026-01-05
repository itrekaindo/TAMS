<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;

// Auth routes (login, register, dll)
require __DIR__.'/auth.php';

// Landing page
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

Route::get('peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])
        ->name('peminjaman.kembalikan');
Route::post('peminjaman/{id}/proses-kembalikan', [PeminjamanController::class, 'prosesKembalikan'])
        ->name('peminjaman.proses-kembalikan');

// Public Routes - Peminjaman
Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');

// Public Routes - Pengembalian
Route::get('/pengembalian', [PeminjamanController::class, 'cariPeminjaman'])->name('pengembalian.cari');
Route::post('/pengembalian/cari', [PeminjamanController::class, 'prosesCariPeminjaman'])->name('pengembalian.proses-cari');
Route::get('/pengembalian/{kode}', [PeminjamanController::class, 'formPengembalian'])->name('pengembalian.form');
Route::post('/pengembalian/{id}/submit', [PeminjamanController::class, 'submitPengembalian'])->name('pengembalian.submit');


// Semua route di bawah ini hanya untuk user yang sudah login
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Route untuk import alat
    Route::get('/alat/import', [AlatController::class, 'importForm'])->name('alat.import.form');
    Route::post('/alat/import', [AlatController::class, 'import'])->name('alat.import');
    Route::get('/alat/template', [AlatController::class, 'downloadTemplate'])->name('alat.template');

    Route::resource('alat', AlatController::class);
    Route::resource('peminjam', PeminjamController::class);
    Route::resource('peminjaman', PeminjamanController::class)->except(['create', 'store']);

    Route::get('/peminjaman/{id}/items', [PeminjamanController::class, 'getItems'])
        ->name('peminjaman.items');



    Route::post('alat/{alat}/adjust-stock', [AlatController::class, 'adjustStock'])
        ->name('alat.adjust-stock');

    Route::prefix('api')->group(function () {
        Route::get('alat/{id}', [PeminjamanController::class, 'getAlatDetail'])
            ->name('api.alat.detail');
        Route::get('peminjam/{id}', [PeminjamController::class, 'getPeminjamDetail'])
            ->name('api.peminjam.detail');
    });

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});
