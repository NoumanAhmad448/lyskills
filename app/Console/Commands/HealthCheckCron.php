<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Artisan;

class HealthCheckCron extends BaseCron
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:health-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Custom cron wrapper for Laravel health:check command with tracking';

    /**
     * Execute the console command.
     */
    public function runCron()
    {
        Artisan::call('health:check');
    }
}
