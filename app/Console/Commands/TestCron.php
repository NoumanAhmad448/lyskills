<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestCron extends Command
{
    // Command signature
    protected $signature = 'cron:test';

    // Command description
    protected $description = 'Simple test cron to check if scheduler is running';

    public function handle()
    {
        $message = 'Test cron ran successfully at ' . now();
        $this->info($message);
        Log::info($message); // will write to storage/logs/laravel.log
    }
}
