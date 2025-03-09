<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (! Schema::hasTable('cron_jobs')) {
            Schema::create('cron_jobs', function (Blueprint $table) {
                $table->increments("id")->comment('Primary Key');
                $table->string("name")->comment('Job name');
                $table->text("w_name")->nullable()->comment('Website Name');
                $table->enum('status', [
                    'idle',
                    'successed',
                    'error'
                ])->nullable()->comment('Status');
                $table->text("message")->nullable()->comment('Message on error/successful');
                $table->timestamp('starts_at')->useCurrent()->comment('Start Job Timestamp');
                $table->timestamp('ends_at')->useCurrent()->comment('End Job Timestamp');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists(config('table.cron_jobs'));
    }
};
