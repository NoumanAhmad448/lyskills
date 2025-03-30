<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment("student id");
            $table->integer('course_id');
            $table->string('code')->unique();
            $table->unsignedInteger('download_count')->default(0)->comment("how many times user has downloaded the certificate"); // New column
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificates');
    }
};
