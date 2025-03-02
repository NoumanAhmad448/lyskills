<?php

namespace Database\Factories;

use App\Models\SubCategory;
use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SubCategoryFactory extends Factory
{
    protected $model = SubCategory::class;
    private $faker;

    public function __construct()
    {
    }

    public function definition()
    {
        $name = fake()->words();
        return [
            'name' => ucwords($name),
            'value' => Str::slug($name),
            'categories_id' => Categories::factory(),
            'description' => fake()->sentence(),
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

    public function webDevelopment()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Web Development',
                'value' => 'web-development',
            ];
        });
    }

    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'inactive',
            ];
        });
    }
}