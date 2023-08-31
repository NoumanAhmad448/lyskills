<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lecture_id')->nullable();
            $table->string('lec_name')->nullable();            
            $table->string('f_name')->nullable();            
            $table->string('f_mimetype')->nullable();            
            $table->string('course_id')->nullable();            
            $table->string('duration');            
            $table->string('time_in_mili');            
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
        Schema::dropIfExists('media');
    }
}
