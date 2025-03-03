<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (app()->environment(config("app.testing_env"))) {
            $this->call([
                UserSeeder::class,
                CategoriesSeeder::class,
                SubCategorySeeder::class,
                PostSeeder::class,
                FaqSeeder::class,
                PageSeeder::class,
                CourseSeeder::class,
                InstructorPaymentSeeder::class,
            ]);
        }
    }
}
