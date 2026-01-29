<?php

namespace App\Console\Commands;

use App\Classes\EnrolledCourseTotalOverdueCount;
use App\Models\Notification;

class OverdueStudentsNotificationCron extends BaseCron
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:overdue-students';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate the overdue students';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function runCron()
    {


        $count = EnrolledCourseTotalOverdueCount::get();

        if ($count > 0) {
            Notification::create([
                'type'  => 'overdue_students',
                'count' => $count,
                'route' => [
                    'route' => 'students.index',
                    'route_keys' => ['type' => 'overdue'],
                ],
            ]);
        }
    }
}
