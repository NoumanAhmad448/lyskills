<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use App\Models\Categories;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    private $faker;
    public function __construct() {
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get IT category or create it if doesn't exist
        $itCategory = Categories::where('value', 'it')->first() ??
            Categories::factory()->create([
                'name' => 'Information Technology',
                'value' => 'it'
            ]);

        // Web Development subcategories
        $webDevSubCategories = [
            [
                'name' => 'Frontend Development',
                'value' => 'frontend-development',
                'categories_id' => $itCategory->id
            ],
            [
                'name' => 'Backend Development',
                'value' => 'backend-development',
                'categories_id' => $itCategory->id
            ],
            [
                'name' => 'Full Stack Development',
                'value' => 'full-stack-development',
                'categories_id' => $itCategory->id
            ]
        ];

        foreach ($webDevSubCategories as $subCategory) {
            SubCategory::create($subCategory);
        }

        // Get all categories except IT
        $otherCategories = Categories::where('id', '!=', $itCategory->id)->get();

        // Create 2 random subcategories for each remaining category
        if($otherCategories->count()){
        foreach ($otherCategories as $category) {
            SubCategory::factory()
                ->count(2)
                ->create([
                    'categories_id' => $category->id
                ]);
            }
        }

        // Create one inactive subcategory
        SubCategory::factory()
            ->inactive()
            ->create([
                'categories_id' => $itCategory->id
            ]);
    }
}