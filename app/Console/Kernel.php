<?php

namespace App\Console;

use App\Console\Commands\CheckUrlAccessibility;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\Log\ClearLogFile;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command("cron:health-check")->everyMinute();
        $schedule->command("log:clear")->daily();
        $schedule->command("check:url-accessibility")->everyMinute();
        $schedule->command('cron:telescope-prune')->everyMinute();
        $schedule->command('env:check-consistency')->everyMinute();
        $schedule->command('app:check-debug')->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
