<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;  // This will ensure fresh database for each test

    protected function setUp(): void
    {
        parent::setUp();

        // Optional: You can add additional checks
        if (env('DB_DATABASE') !== config('database.testing_db')) {
            throw new \Exception('Not using testing database! Current DB: ' . env('DB_DATABASE'));
        }

        // Seed the database for testing
        // check the following seeder the future
        // $this->seed();
    }
}
