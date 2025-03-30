<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class RegistrationTest extends DuskTestCase
{
    public function testUserRegistration()
    {
        $this->browse(function (Browser $browser) {
            $response = $this->registerUser($browser, [
                'name' => fake()->name(),
                'email' => fake()->unique()->email(),
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response->assertUrlIs(route("index")."/"); // Adjust based on your app's flow
        });
    }
}
