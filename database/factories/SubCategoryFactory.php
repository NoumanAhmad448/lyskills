<?php

namespace Database\Factories;

use App\Models\SubCategory;
use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Classes\Faker;
class SubCategoryFactory extends Factory
{
    protected $model = SubCategory::class;
    private $faker;

    public function __construct()
    {
        $this->faker = new Faker;
    }

    public function definition()
    {
        $name = $this->faker->words();
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