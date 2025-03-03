<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $pass = $this->faker->bothify('????####');
        debug_logs($pass);
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email,
            'email_verified_at' => now(),
            'password' => Hash::make($pass),
            'remember_token' => Str::random(10),
        ];
    }
}
