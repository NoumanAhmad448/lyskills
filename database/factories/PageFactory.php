<?php

namespace Database\Factories;

use App\Models\Page;
use App\Models\User;
use Cocur\Slugify\Slugify;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition()
    {
        $title = $this->faker->sentence();
        $user = User::factory()->create();
        return [
            'title' => $title,
            'slug' => (new Slugify())->slugify($title),
            'message' => implode("\n\n",$this->faker->paragraphs(5)),
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