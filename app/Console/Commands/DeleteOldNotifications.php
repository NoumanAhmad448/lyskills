<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Classes\LyskillsCarbon;

class DeleteOldNotifications extends BaseCron
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:delete-old-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete notifications older than the current month';

    /**
     * Execute the console command.
     */
    public function runCron()
    {
        $cutoffDate = LyskillsCarbon::now()->startOfMonth();

        $deleted = Notification::where('created_at', '<', $cutoffDate)
            ->delete();

        $this->info("Deleted {$deleted} old notifications before {$cutoffDate->toDateString()}");
    }
}
