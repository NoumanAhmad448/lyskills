<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Config;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @group global-tests
 */
class UserDeletionOptionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_user_deletion_option_shows_when_en_delete_user_is_enabled()
    {
        // Set 'en_delete_user' config to true (enabled)
        Config::set('setting.en_delete_user', true);

        $user = User::factory()->create();

        // Act as the logged-in user
        $this->actingAs($user);

        // Visit the profile page
        $response = $this->get('/user/profile');

        // Assert that the delete user option is present in the page
        $response->assertSee('Delete Account'); // Adjust based on actual view content
    }

    public function test_user_deletion_option_does_not_show_when_en_delete_user_is_disabled()
    {
        // Set 'en_delete_user' config to false (disabled)
        Config::set('setting.en_delete_user', false);

        $user = User::factory()->create();

        // Act as the logged-in user
        $this->actingAs($user);

        // Visit the profile page
        $response = $this->get('/user/profile');

        // Assert that the delete user option is not present in the page
        $response->assertDontSee('Delete Account'); // Adjust based on actual view content
    }
}
