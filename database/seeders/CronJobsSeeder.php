<?php

namespace Database\Seeders;

use App\Models\CronJobs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CronJobsSeeder extends Seeder
{
    private $total_cron_jobs = 5;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CronJobs::factory()->count($this->total_cron_jobs)->create([
            "name" => fake()->word,
            "w_name" => fake()->domainName,
            'status' => fake()->randomElement([
                config('constants.idle') ?? 'idle',
                config('constants.successed') ?? 'successed',
                config('constants.error') ?? 'error',
            ]),
            'message' => fake()->sentence,
            'starts_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'ends_at' => fake()->dateTimeBetween('now', '+1 month'),
        ]);
    }
}
