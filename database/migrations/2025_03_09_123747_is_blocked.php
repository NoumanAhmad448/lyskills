<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (Schema::hasTable('users')) { // Check if users table exists
            Schema::table('users', function (Blueprint $table) {
                    $table->boolean('is_blocked')->default(false)->after('email');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('users')) { // Check if users table exists before removing the column
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('is_blocked')) { // Check if column exists before dropping
                    $table->dropColumn('is_blocked');
                }
            });
        }
    }
};
