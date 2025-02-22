<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'homepage_photo')) {
                $table->string('homepage_photo')->nullable();
            }
            if (!Schema::hasColumn('settings', 'homepage_photo_name')) {
                $table->string('homepage_photo_name')->nullable();
            }
            if (!Schema::hasColumn('settings', 'homepage_photo_updated_at')) {
                $table->timestamp('homepage_photo_updated_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['homepage_photo', 'homepage_photo_name', 'homepage_photo_updated_at']);
        });
    }
};