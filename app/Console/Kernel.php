<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Cek keterlambatan setiap hari jam 08:00 pagi
        $schedule->command('peminjaman:cek-terlambat')
                 ->dailyAt('08:00')
                 ->timezone('Asia/Jakarta');

        // Kirim reminder H-1 setiap hari jam 09:00 pagi
        $schedule->command('peminjaman:reminder-pengembalian')
                 ->dailyAt('09:00')
                 ->timezone('Asia/Jakarta');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
