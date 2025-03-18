<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use App\Models\Categories;
use App\Models\CourseImage;
use App\Models\CourseVideo;
use App\Models\Media;
use App\Models\Pricing;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;  // Import the Faker Factory class

class CourseSeeder extends Seeder
{
    protected $faker;
    public function __construct()
    {
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

        // $this->call([
        // CategoriesSeeder::class,
        // LanguageSeeder::class,
        // ]);

        if (config("app.debug")) {
            debug_logs($instructor);
        }
        // Get IT category or create it
        $itCategory = Categories::where('value', 'it')->first() ??
            Categories::factory()->create([
                'name' => 'Information Technology',
                'value' => 'it'
            ]);
        if (config("app.debug")) {
            debug_logs($itCategory);
        }
        // Create one draft course
        $course = Course::factory()
            ->create([
                'user_id' => $instructor->id,
                'categories_selection' => $itCategory->value,
                'status' => 'published',
                'is_draft' => true
            ]);
        if (config("app.debug")) {
            debug_logs($course);
        }

        Pricing::factory()->create([
            'course_id' => $course->id,
            'pricing' => 19.99
        ]);

        if (config("app.debug")) {

            debug_logs($course->price);
        }

        // Create courses for other categories
        Categories::where('value', '!=', 'it')->get()->each(function ($category) use ($instructor) {
            if (config("app.debug")) {
                debug_logs("inside the loop");
            }

            $course = Course::factory()
                ->count(2)
                ->create([
                    'user_id' => $instructor->id,
                    'categories_selection' => $category->value,
                    'status' => 'published',
                    'is_draft' => false
                ]);
            if (config("app.debug")) {

                debug_logs($course);
            }
            $course->each(function ($course) {
                Pricing::factory()->create([
                    'course_id' => $course->id,
                    'pricing' => 19.99
                ]);

                Media::factory()
                    ->set_lecture($course->id)
                    ->create();

                CourseImage::factory()->create([
                    'course_id' => $course->id,
                ]);
                CourseVideo::factory()->create(
                    [
                        'course_id' => $course->id,
                    ]
                );
                if (config("app.debug")) {

                    debug_logs($course->price);
                }
            });
        });
    }
}
