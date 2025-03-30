<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\CronJobs;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @group global-tests
 */
class CronJobsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $total_cron_jobs = 5;
    protected $cron_jobs;
    protected $dev;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cron_jobs = CronJobs::factory($this->total_cron_jobs)->create([
            "name" => $this->faker->name(),
            "w_name" => $this->faker->name(),
            "status" => $this->faker->randomElement([
                "idle",
                "successed",
                "error",
            ]),
            "message" => $this->faker->sentence(),
            "starts_at" => $this->faker->dateTimeBetween("-1 month", "now"),
            "ends_at" => $this->faker->dateTimeBetween("now", "+1 month"),
        ]);
        $this->dev = User::factory()->create(["role" => "dev"]);
    }

    /** @test */
    public function it_displays_paginated_cron_jobs_in_view()
    {
        $this->actingAs($this->dev);
        // Hit the route that returns the view with paginated CronJobs.
        $response = $this->get(route('dev.get.cron_jobs')); // Update route if necessary

        // Assert that the response has a 200 status code.
        $response->assertOk();

        // Assert that the expected view is returned.
        $response->assertViewIs('dev.cron_jobs.get_cron_jobs');

        $response->assertViewHas('cron_jobs', function ($cronJobs) {
            // Ensure the paginated instance has exactly 40 items on the first page
            return $cronJobs->count() <= config("setting.cron_paginate") && $cronJobs->total() === $this->total_cron_jobs;
        });
    }
}
