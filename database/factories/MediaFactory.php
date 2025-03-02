<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    protected $model = Media::class;
    private $faker;

    public function __construct() {
    }

    public function definition()
    {
        return [
            'course_id' => Course::factory(),
            'media_path' => 'media/default-' . uniqid() . '.mp4',
            'media_name' => fake()->words(3, true) . '.mp4',
            'type' => fake()->randomElement(['video', 'image', 'document']),
            'duration' => fake()->numberBetween(300, 3600), // 5-60 minutes
            'size' => fake()->numberBetween(1000000, 100000000), // 1MB-100MB
            'is_preview' => false,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

    public function preview()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_preview' => true
            ];
        });
    }

    public function image()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'image',
                'media_path' => 'media/image-' . uniqid() . '.jpg',
                'media_name' => fake()->words(3, true) . '.jpg',
                'duration' => null
            ];
        });
    }
} 