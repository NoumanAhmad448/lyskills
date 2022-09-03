<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('headline',40)->nullable();
            $table->text('bio')->nullable();
            $table->string('website',255)->nullable();
            $table->string('twitter',255)->nullable();
            $table->string('facebook',255)->nullable();
            $table->string('linkedin',255)->nullable();
            $table->string('youtube',255)->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
