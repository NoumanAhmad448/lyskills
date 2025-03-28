<?php

namespace Database\Factories;

use App\Models\UserAnnModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAnnModel>
 */
class UserAnnModelFactory extends Factory
{
    protected $model = UserAnnModel::class;

    public function definition()
    {
        return [
            'message' => substr($this->faker->paragraph(2),224),
        ];
    }
}
