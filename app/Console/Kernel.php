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
        // $schedule->command('inspire')->everyMinute();
        $schedule->command('report:send-weekly')->weekly()->fridays()->at('16:30');
        $schedule->command('report:send-weekly')->weekly()->fridays()->at('20:00');
        $schedule->command('report:send-weekly')->weekly()->mondays()->at('13:00'); //en hora del servidor deberían ser 7am del lunes
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
