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
        $schedule->command('app:initiate-poll')->dailyAt('10:10')->weekdays();
        $schedule->command('app:broadcast-daily-word')->dailyAt('07:45')->weekdays();
        $schedule->command('app:broadcast-random-message')->everyTwoHours()->between('06:00', '16:00')->weekdays();
        $schedule->command('app:broadcast-friday-message')->at('13:55')->fridays();
        $schedule->command('app:broadcast-arg-message')->at('13:55')->mondays();
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
