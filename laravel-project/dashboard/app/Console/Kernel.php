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
        // Run the pending payment expiry every 5 minutes using configured timeout
        $minutes = (int) config('payments.pending_expire_minutes', 30);
        $schedule->command("payments:expire-pending --minutes={$minutes}")->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        // Load all console commands from the Commands directory
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
