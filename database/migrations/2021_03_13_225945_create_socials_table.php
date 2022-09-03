<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socials', function (Blueprint $table) {
            $table->id();
            $table->boolean('f_enable')->nullable();
            $table->string('f_app_id')->nullable();
            $table->string('f_security_key')->nullable();
            $table->boolean('g_enable')->nullable();
            $table->string('g_app_id')->nullable();
            $table->string('g_security_key')->nullable();
            $table->boolean('l_enable')->nullable();
            $table->string('l_app_id')->nullable();
            $table->string('l_security_key')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socials');
    }
}
