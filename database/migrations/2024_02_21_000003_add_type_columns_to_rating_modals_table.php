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
        Schema::table('rating_modals', function (Blueprint $table) {
            if (!Schema::hasColumn('rating_modals', 'type')) {
                $table->string('type')->nullable();
            }
            if (!Schema::hasColumn('rating_modals', 'type_of')) {
                $table->text('type_of')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rating_modals', function (Blueprint $table) {
            if (Schema::hasColumn('rating_modals', 'type')) {
                $table->dropColumn('type');
            }
            if (Schema::hasColumn('rating_modals', 'type_of')) {
                $table->dropColumn('type_of');
            }
        });
    }
}; 