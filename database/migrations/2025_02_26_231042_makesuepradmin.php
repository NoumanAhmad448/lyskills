<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        User::firstOrCreate(
            ['email' => 'admin@lyskills.com'],  // Check if user exists by email
            [
                'name' => 'Super Admin',
                'password' => Hash::make('konichiwa'),  // Secure password hashing
                'is_super_admin' => true,
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ]
        );
        
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
