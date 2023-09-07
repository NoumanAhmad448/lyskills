<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Promotion;

class AlterPromotion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotions',function($table){
            $table->boolean('is_free')->nullable();
            $table->date('date_time')->nullable();
            $table->string('no_of_coupons')->nullable();
            $table->string('percentage')->nullable();
        });
        Promotion::query()->update(['is_free'=>1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropColumn(['is_free', 'date_time', 'no_of_coupons','percentage']);
        });
    }
}
