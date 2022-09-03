<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_statuses', function (Blueprint $table) {
            $table->id();
            $table->integer('course_id')->nullable();
            $table->string('target_ur_students')->nullable();
            $table->string('curriculum')->nullable();
            $table->string('landing_page')->nullable();
            $table->string('pricing')->nullable();
            $table->string('course_img')->nullable();
            $table->string('course_video')->nullable();
            $table->string('message')->nullable();
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
        Schema::dropIfExists('course_statuses');
    }
}
