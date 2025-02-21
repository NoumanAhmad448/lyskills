<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\User;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('is_admin', true)->first() ?? User::factory()->create(['is_admin' => true]);

        Faq::factory()
            ->count(5)
            ->create([
                'email' => $admin->email,
                'status' => 'published',
                'is_published' => true
            ]);
    }
}