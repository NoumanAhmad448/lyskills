<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use App\Models\Categories;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
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
                         'email' => 'instructor@lyskills.com'
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
                'email' => $instructor->email,
                'categories_selection' => $itCategory->value,
                'status' => 'published',
                'is_draft' => false
            ]);

        // Create one draft course
        Course::factory()
            ->create([
                'email' => $instructor->email,
                'categories_selection' => $itCategory->value,
                'status' => 'draft',
                'is_draft' => true
            ]);

        // Create courses for other categories
        Categories::where('value', '!=', 'it')->get()->each(function ($category) use ($instructor) {
            Course::factory()
                ->count(2)
                ->create([
                    'email' => $instructor->email,
                    'categories_selection' => $category->value,
                    'status' => 'published',
                    'is_draft' => false
                ]);
        });
    }
} 