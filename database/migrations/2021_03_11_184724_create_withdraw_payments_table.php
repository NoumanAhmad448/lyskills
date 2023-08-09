<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraw_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('b_min')->nullable();
            $table->string('b_note')->nullable();
            $table->string('p_min')->nullable();
            $table->string('p_note')->nullable();
            $table->string('e_min')->nullable();
            $table->string('e_note')->nullable();
            $table->string('j_min')->nullable();
            $table->string('j_note')->nullable();            
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
        Schema::dropIfExists('withdraw_payments');
    }
}
