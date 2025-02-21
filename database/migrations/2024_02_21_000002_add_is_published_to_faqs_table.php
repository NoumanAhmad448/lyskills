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
        if(Schema::hasTable('faqs')){
            Schema::table('faqs', function (Blueprint $table) {
                if (!Schema::hasColumn('faqs', 'is_published')) {
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
        Schema::table('faqs', function (Blueprint $table) {
            if (Schema::hasColumn('faqs', 'is_published')) {
                $table->dropColumn('is_published');
            }
        });
    }
}; 