<?php

namespace Database\Factories;

use App\Models\InstructorAnn;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstructorAnnFactory extends Factory
{
    protected $model = InstructorAnn::class;
    
    public function definition()
    {
        return [
            'message' => $this->faker->paragraph(),
            'created_at' => $this->faker->dateTimeBetween('-1 month')
        ];
    }
} 