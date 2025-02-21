<?php

namespace Database\Factories;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoriesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Categories::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->unique()->words(2, true);
        return [
            'name' => ucwords($name),
            'value' => Str::slug($name),
            'description' => $this->faker->sentence(),
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the category is inactive.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'inactive',
            ];
        });
    }

    /**
     * Indicate that the category is for IT courses.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function itCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Information Technology',
                'value' => 'it',
                'description' => 'All IT related courses',
            ];
        });
    }

    /**
     * Indicate that the category is for business courses.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function businessCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Business',
                'value' => 'business',
                'description' => 'All business related courses',
            ];
        });
    }
} 