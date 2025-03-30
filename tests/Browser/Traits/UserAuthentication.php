<?php

namespace Tests\Browser\Traits;

use Laravel\Dusk\Browser;

trait UserAuthentication
{
    /**
     * Log in a user.
     */
    public function loginUser(Browser $browser, $email, $password)
    {
        $browser->visit('/login')
                ->type('email', $email)
                ->type('password', $password)
                ->press('Login');
    }

    /**
     * Log out a user.
     */
    public function logoutUser(Browser $browser)
    {
        $browser->click('.logout-button') // Adjust the selector as needed
                ->assertPathIs('/');
    }

    public function registerUser(Browser $browser, array $userData)
    {
        return $browser->visit('/register')
                ->type('name', $userData['name'])
                ->type('email', $userData['email'])
                ->type('password', $userData['password'])
                ->type('password_confirmation', $userData['password_confirmation'])
                ->check('terms')
                ->press('Register');
    }
}