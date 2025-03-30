<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;  // Import the Faker Factory class

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Information Technology',
                'value' => 'it'
            ],
            [
                'name' => 'Business',
                'value' => 'business'
            ],
            [
                'name' => 'Marketing',
                'value' => 'marketing'
            ]
        ];

        foreach ($categories as $category) {
            debug_logs($categories);
            Categories::create($category);
        }
    }
}