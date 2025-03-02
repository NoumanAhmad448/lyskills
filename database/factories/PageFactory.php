<?php

namespace Database\Factories;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Classes\Faker;


class PageFactory extends Factory
{
    protected $model = Page::class;
    private $faker;
    public function __construct() {
        $this->faker = new Faker;
    }
    public function definition()
    {
        $title = $this->faker->sentence();
        $user = User::factory()->create();
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'message' => $this->faker->paragraphs(5),
            'status' => 'published',
            'created_at' => now(),
            'updated_at' => now(),
            'email' => $user->email,
            'upload_img' => 'pages/default.jpg',
            'f_name' => 'default.jpg',
            'name' => $user->name,
        ];
    }
}