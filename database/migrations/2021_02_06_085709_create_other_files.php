<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_files', function (Blueprint $table) {
            $table->id();
            $table->string('lecture_id')->nullable();
            $table->string('f_path')->nullable();
            $table->string('f_name')->nullable();
            $table->string('saved_f_name')->nullable();

            $table->string('f_mimetype')->nullable();
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
        Schema::dropIfExists('other_files');
    }
}
