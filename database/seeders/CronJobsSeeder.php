<?php

namespace Database\Seeders;

use App\Models\CronJobs;
use Illuminate\Database\Seeder;

class CronJobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CronJobs::create([
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
