<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @group global-tests
 */
class CommandsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function test_check_url_accessiability()
    {
        $this->artisan('check:url-accessibility')
            ->assertExitCode(0);
    }

    /** @test */
    public function test_check_log_clear()
    {
        $this->artisan('log:clear')
            ->assertExitCode(0);
    }
}
