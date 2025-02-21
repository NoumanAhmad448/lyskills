<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfflinePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('offline_payments')) {
            Schema::create('offline_payments', function (Blueprint $table) {
                $table->increments('id');

            $table->boolean('o_is_enable')->nullable();
            $table->string('o_mobile_number')->nullable();
            $table->string('o_note')->nullable();

            $table->boolean('e_is_enable')->nullable();
            $table->string('e_mobile_number')->nullable();
            $table->string('e_account_name')->nullable();
            $table->string('e_note')->nullable();

            $table->boolean('j_is_enable')->nullable();
            $table->string('j_mobile_number')->nullable();
            $table->string('j_account_name')->nullable();
            $table->string('j_note')->nullable();

            $table->boolean('b_is_enable')->nullable();
            $table->string('b_bank_name')->nullable();
            $table->string('b_swift_code')->nullable();
            $table->string('b_account_name')->nullable();
            $table->string('b_account_number')->nullable();
            $table->string('b_branch_name')->nullable();
            $table->string('b_branch_address')->nullable();
            $table->string('b_iban')->nullable();
            $table->string('b_note')->nullable();

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
        Schema::dropIfExists('offline_payments');
    }
}
