<?php

namespace Database\Factories;

use App\Models\InstructorAnn;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstructorAnnFactory extends Factory
{
    protected $model = InstructorAnn::class;
    private $faker;
    public function __construct() {
    }

    public function definition()
    {
        return [
            'message' => fake()->paragraph(),
            'created_at' => fake()->dateTimeBetween('-1 month')
        ];
    }
} 