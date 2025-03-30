<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;  // This will ensure fresh database for each test
    public $run_seeder = false;

    protected function setUp(): void
    {
        parent::setUp();

        // Optional: You can add additional checks
        if (config('database.current_db') !== config('database.testing_db')) {
            $msg = 'Not using testing database! Current DB:' . config('database.current_db');
            debug_logs($msg);

            throw new \Exception($msg);
        }

        if ($this->run_seeder) {
            // Seed the database for testing
            // check the following seeder the future
            $this->seed(\Database\Seeders\DatabaseSeeder::class);
        }

        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        if (config("app.env") == config("app.dev_env")) {
            Artisan::call("storage:link-custom");
        }
    }
    protected function runSeeder()
    {
        $this->run_seeder = true;
        return $this;
    }
}
