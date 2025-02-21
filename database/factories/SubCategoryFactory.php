<?php

namespace Database\Factories;

use App\Models\SubCategory;
use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SubCategoryFactory extends Factory
{
    protected $model = SubCategory::class;

    public function definition()
    {
        $name = $this->faker->unique()->words(2, true);
        return [
            'name' => ucwords($name),
            'value' => Str::slug($name),
            'categories_id' => Categories::factory(),
            'description' => $this->faker->sentence(),
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