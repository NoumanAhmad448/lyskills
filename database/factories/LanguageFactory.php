<?php

namespace Database\Factories;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class LanguageFactory extends Factory
{
    protected $model = Language::class;
    private $faker;
    public function __construct() {
    }

    public function definition(): array
    {
        return [
            'name' => fake()->languageCode,
            'iso_639_1' => fake()->unique()->lexify('??'),
        ];
    }
}
