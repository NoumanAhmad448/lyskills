<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use App\Models\Categories;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;  // Import the Faker Factory class

class CourseSeeder extends Seeder
{
    public function __construct() {
        // You can instantiate the Faker factory here if needed
        $this->faker = Faker::create();  // Manually instantiate the Faker object
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get or create instructor
        $instructor = User::where('is_instructor', true)->first() ??
                     User::factory()->create([
                         'is_instructor' => true,
                         'email' => $this->faker->email()
                     ]);

        // Get IT category or create it
        $itCategory = Categories::where('value', 'it')->first() ??
                     Categories::factory()->create([
                         'name' => 'Information Technology',
                         'value' => 'it'
                     ]);

        // Create published courses
        Course::factory()
            ->count(3)
            ->create([
                'user_id' => $instructor->id,
                'categories_selection' => $itCategory->value,
                'status' => 'published',
                'is_draft' => false
            ]);

        // Create one draft course
        Course::factory()
            ->create([
                'user_id' => $instructor->id,
                'categories_selection' => $itCategory->value,
                'status' => 'draft',
                'is_draft' => true
            ]);

        // Create courses for other categories
        Categories::where('value', '!=', 'it')->get()->each(function ($category) use ($instructor) {
            Course::factory()
                ->count(2)
                ->create([
                    'user_id' => $instructor->id,
                    'categories_selection' => $category->value,
                    'status' => 'published',
                    'is_draft' => false
                ]);
        });
    }
}