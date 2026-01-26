<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

// Cek keterlambatan setiap hari jam 08:00 pagi
Schedule::command('peminjaman:cek-terlambat')
    ->dailyAt('08:00')
    ->timezone('Asia/Jakarta');

// Kirim reminder H-1 setiap hari jam 09:00 pagi
Schedule::command('peminjaman:reminder-pengembalian')
    ->dailyAt('09:00')
    ->timezone('Asia/Jakarta');
