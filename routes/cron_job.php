<?php

use App\Http\Controllers\CronJob;
use Illuminate\Support\Facades\Route;


Route::domain(config("app.url"))->prefix("dev")->middleware("is_dev")->group(function(){
    Route::get('/get-cron-jobs', [CronJob::class, "getCronJob"])->name('dev.get.cron_jobs');
});