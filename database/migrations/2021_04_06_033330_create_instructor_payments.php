<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructor_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->text('j_account')->nullable();
            $table->text('e_account')->nullable();
            $table->text('paypal_account')->nullable();
            $table->text('payoneer_account')->nullable();
            $table->text('b_name')->nullable();
            $table->text('b_swift_code')->nullable();
            $table->text('b_account_name')->nullable();
            $table->text('b_account_no')->nullable();
            $table->text('b_branch_name')->nullable();
            $table->text('b_branch_addr')->nullable();
            $table->text('b_iban')->nullable();
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
        Schema::dropIfExists('instructor_payments');
    }
}
