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
            ],
            [
                'name' => 'Design',
                'value' => 'design'
            ],
            [
                'name' => 'Development',
                'value' => 'development'
            ],
            [
                'name' => 'Finance',
                'value' => 'finance'
            ],
            [
                'name' => 'Health',
                'value' => 'health'
            ],
            [
                'name' => 'Music',
                'value' => 'music'
            ]
        ];

        foreach ($categories as $category) {
            Categories::create($category);
        }
    }
}