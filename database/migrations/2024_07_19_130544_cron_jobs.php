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
        if (! Schema::hasTable(config('table.cron_jobs'))) {
            Schema::create(config('table.cron_jobs'), function (Blueprint $table) {
                $table->increments(config('table.primary_key'))->comment('Primary Key');
                $table->string(config('table.name'))->comment('Job name');
                $table->text(config('table.w_name'))->nullable()->comment('Website Name');
                $table->enum(config('table.status'), [
                    config('constants.idle'),
                    config('constants.successed'),
                    config('constants.error'),
                ])->nullable()->comment('Status');
                $table->text(config('table.message'))->nullable()->comment('Message on error/successful');
                $table->timestamp(config('table.starts_at'))->useCurrent()->comment('Start Job Timestamp');
                $table->timestamp(config('table.ends_at'))->useCurrent()->comment('End Job Timestamp');
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
