<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class  extends Migration
{
    public function up()
    {
        // Check if the `users` table exists
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                // Add the `role` column
                $table->string('role')->default('user'); // Default role is 'user'
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                // Drop the `role` column if it exists
                $table->dropColumn('role');
            });
        }
    }
};