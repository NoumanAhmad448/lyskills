<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\CronJobs;
use Illuminate\Foundation\Testing\WithFaker;

class CronJobsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $total_cron_jobs = 5;
    protected $cron_jobs;

    protected function setUp(): void{
        parent::setUp();
        CronJobs::factory()->create();
        dd("hit");
        $this->cron_jobs = CronJobs::factory()->create();
    }

    /** @test */
    public function it_displays_paginated_cron_jobs_in_view()
    {
        // Create 50 dummy CronJobs records.
        // Artisan::call('db:seed', ['--class' => 'CronJobsSeeder']);

        // Hit the route that returns the view with paginated CronJobs.
        $response = $this->get(route('dev.get.cron_jobs')); // Update route if necessary

        // Assert that the response has a 200 status code.
        $response->assertStatus(200);

        // Assert that the expected view is returned.
        $response->assertViewIs('dev.cron_jobs.get_cron_jobs');

        $response->assertViewHas('cron_jobs', function($cronJobs) {
            // Ensure the paginated instance has exactly 40 items on the first page
            return $cronJobs->count() <= config("setting.cron_paginate") && $cronJobs->total() === $this->total_cron_jobs;
        });
    }
}
