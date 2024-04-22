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
        $schedule->command('app:initiate-poll')->dailyAt('12:10')->weekdays();
        $schedule->command('app:broadcast-daily-word')->dailyAt('09:45');
        $schedule->command('app:broadcast-random-message')->hourly()->between('08:00', '18:00')->weekdays();
        $schedule->command('app:broadcast-friday-message')->at('15:55')->fridays();
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
