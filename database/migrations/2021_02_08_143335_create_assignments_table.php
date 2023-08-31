<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lecture_id')->nullable();
            $table->string('title',255)->nullable();
            $table->string('course_no',255)->nullable();
            $table->string('ass_f_name')->nullable();
            $table->string('ass_f_path')->nullable();
            $table->string('ass_no',255)->nullable();            
            $table->string('ass_ans_f_name')->nullable();
            $table->string('ass_ans_f_path')->nullable();

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
        Schema::dropIfExists('assignments');
    }
}
