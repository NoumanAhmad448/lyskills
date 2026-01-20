<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Classes\LyskillsCarbon;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (class_exists(\App\Models\User::class)) {
            User::firstOrCreate(
                ['email' => 'admin@lyskills.com'],  // Check if user exists by email
                [
                    'name' => 'Super Admin',
                    'password' => Hash::make('konichiwa'),  // Secure password hashing
                    'is_super_admin' => true,
                    'is_admin' => true,
                    'email_verified_at' => LyskillsCarbon::now(),
                    'created_at' => LyskillsCarbon::now(),
                ]
            );
        }
        else {
            echo "❌ Error: User model does not exist. Please check your models directory.";
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
