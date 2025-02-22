<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('articles')){
            Schema::table('articles', function (Blueprint $table) {
                if (!Schema::hasColumn('articles', 'is_published')) {
                    $table->boolean('is_published')->default(false);
                }
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
        Schema::table('articles', function (Blueprint $table) {
            if (Schema::hasColumn('articles', 'is_published')) {
                $table->dropColumn('is_published');
            }
        });
    }
}; 