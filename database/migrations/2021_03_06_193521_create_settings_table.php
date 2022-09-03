<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('isDisscussion')->nullable();
            $table->boolean('payment_share_enable')->nullable()->default(0);
            $table->string('admin_share')->nullable();
            $table->string('instructor_share')->nullable();
            $table->boolean('s_is_enable')->nullable();
            $table->string('s_live_key')->nullable();
            $table->string('s_publish_key')->nullable();
            $table->boolean('j_is_enable')->nullable();
            $table->string('j_live_key')->nullable();
            $table->string('j_publish_key')->nullable();
            $table->boolean('e_is_enable')->nullable();
            $table->string('e_live_key')->nullable();
            $table->string('e_publish_key')->nullable();
            $table->string('paypal_is_enable')->nullable();
            $table->string('paypal_email')->nullable();
            $table->string('p_live_key')->nullable();
            $table->string('p_publish_key')->nullable();
            $table->boolean('bank_is_enable')->nullable();            
            $table->boolean('isBlog')->nullable();            
            $table->boolean('isFaq')->nullable();            
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
        Schema::dropIfExists('settings');
    }
}
