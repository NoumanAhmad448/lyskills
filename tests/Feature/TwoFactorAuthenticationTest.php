<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Config;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @group global-tests
 */
class TwoFactorAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }
    public function test_livewire_component_for_2fa_shows_when_en_2f_is_enabled()
    {
        // Set 'en_2f' config to true (enabled)
        Config::set('setting.en_2f', true);

        $user = User::factory()->create();

        // Act as the logged-in user
        $this->actingAs($user);

        // Visit the profile page
        $response = $this->get('/user/profile');

        // Assert the Livewire component for 2FA is present in the page
        $response->assertSeeLivewire("profile.two-factor-authentication-form"); // The Livewire component should be in the page
    }

    public function test_livewire_component_for_2fa_does_not_show_when_en_2f_is_disabled()
    {
        // Set 'en_2f' config to false (disabled)
        Config::set('setting.en_2f', false);

        $user = User::factory()->create();

        // Act as the logged-in user
        $this->actingAs($user);

        // Visit the profile page
        $response = $this->get('/user/profile');

        // Assert the Livewire component for 2FA is not present
        $response->assertDontSeeLivewire("profile.two-factor-authentication-form"); // The Livewire component should not be in the page
    }
}
