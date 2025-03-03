<?php

namespace Database\Factories;

use App\Models\InstructorAnn;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Classes\LyskillsStr;

class InstructorAnnFactory extends Factory
{
    protected $model = InstructorAnn::class;
    
    public function definition()
    {
        return [
            'message' => LyskillsStr::limit($this->faker->paragraph()),
            'created_at' => $this->faker->dateTimeBetween('-1 month')
        ];
    }
} 