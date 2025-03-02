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
        if (config('database.current_db') !== config('database.testing_db')) {
            $msg = 'Not using testing database! Current DB:' . config('database.current_db');
            if(config("app.debug")){
                dump($msg);
            }
            throw new \Exception($msg);
        }

        // Seed the database for testing
        // check the following seeder the future
        // $this->seed();
    }
}
