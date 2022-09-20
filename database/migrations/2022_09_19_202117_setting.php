<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Setting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable("config_settings")){
            Schema::create('config_settings', function (Blueprint $table) {
                $table->bigIncrements("id")->autoIncrement();
                $table->string('key');
                $table->boolean('value');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('config_settings');
    }
}
