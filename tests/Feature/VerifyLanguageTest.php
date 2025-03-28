<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

/**
 * @group global-tests
 */
class VerifyLanguageTest extends TestCase
{
    use RefreshDatabase; // Use this trait if you want to refresh the database for each test

    protected function setUp(): void
    {
        parent::setUp();
    }
    /**
     * Test if the user's language preference is respected when the 'en_user_lang' setting is true.
     *
     * @return void
     */
    public function test_language_is_enabled_based_on_user_preference()
    {
        // Check if the 'en_user_lang' configuration is enabled
        if (!Config::get('setting.en_user_lang')) {
            $this->markTestSkipped('The en_user_lang setting is disabled, skipping test.');
        }

        // Assuming user is logged in, fetch the logged-in user
        $user = User::factory()->create([
            'language' => 'ur' // Example: Spanish, this could be any language stored in the user
        ]);

        // Simulate user authentication (this assumes you are using Laravel's authentication system)
        $this->actingAs($user);

        // Now, make a request to the page that should use the language setting
        $response = $this->get('/'); // Replace '/' with the route you want to test

        // Check if the language is correctly set
        if ($user->language == 'ur') {
            // If the user's language is Spanish, check if Spanish content is displayed
            $response->assertSee("پراؤنڈ فلور اکرم پلازہ، مسلم ٹاؤن، فیروز پور روڈ، بابا قلفی والا کے قریب، لاہور");
        }

        // Optionally, check the application's locale
        $this->assertEquals($user->language, app()->getLocale()); // Ensure locale is set correctly
    }

    public function test_user_update_without_language()
    {
        config()->set('setting.en_user_lang', false); // Disable language validation

        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('user-profile-information.update'), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $response->assertFound();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    public function test_user_update_with_language_enabled()
    {
        config()->set('setting.en_user_lang', true); // Enable language validation

        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('user-profile-information.update'), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'language' => 'en', // Now required due to config setting
        ]);

        $response->assertFound();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'language' => 'en',
        ]);
    }

    public function test_user_update_fails_when_language_is_missing_and_required()
    {
        config()->set('setting.en_user_lang', true); // Language should be validated

        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('user-profile-information.update'), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            // Missing 'language' field
        ]);

        $response->assertFound();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'language' => 'en',
        ]);
    }
}
