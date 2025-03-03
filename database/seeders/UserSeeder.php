<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;  // Import the Faker Factory class

class UserSeeder extends Seeder
{
    public function __construct() {
        // You can instantiate the Faker factory here if needed
        $this->faker = Faker::create();  // Manually instantiate the Faker object
    }

    public function run()
    {

        // Create admin user
        User::factory()->create([
            'name' => $this->faker->name(), // 2 words, separated by space
            'email' => $this->faker->unique()->email(),
            'password' => Hash::make($this->faker->bothify('????####')), // 4 letters followed by 4 digits
            'is_admin' => true,
            'email_verified_at' => now()
        ]);

        // Create instructor

        User::factory()->create([
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),
            'password' => Hash::make($this->faker->bothify('????####')),
            'is_instructor' => true,
            'email_verified_at' => now()
        ]);


        User::factory()->create([
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),  // Use the previous generated email
            'password' => Hash::make($this->faker->bothify('????####')),
            'email_verified_at' => now()
        ]);

        // Create additional users
        User::factory()
            ->count(3)
            ->create();
    }
}
