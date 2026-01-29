<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Artisan;

class TelescopePruneCron extends BaseCron
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:telescope-prune';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Custom cron wrapper for Telescope prune with status tracking';

    /**
     * Execute the console command.
     */
    public function runCron()
    {

        // Run Telescope prune
        Artisan::call('telescope:prune');
    }
}
