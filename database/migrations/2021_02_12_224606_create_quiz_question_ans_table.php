<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizQuestionAnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_question_ans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('quiz_id')->nullable();
            $table->string('course_id')->nullable();
            $table->string('count_quizzes')->nullable();
            $table->string('question',1000)->nullable();
            $table->string('ans1',1000)->nullable();
            $table->string('ans2',1000)->nullable();
            $table->string('ans3',1000)->nullable();
            $table->string('ans4',1000)->nullable();
            $table->string('ans',1000)->nullable();
            $table->string('reason_ans',1000)->nullable();
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
        Schema::dropIfExists('quiz_question_ans');
    }
}
