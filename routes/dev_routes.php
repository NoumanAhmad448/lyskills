<?php

use App\Http\Controllers\DeleteProject;
use App\Http\Controllers\HealthCheckResultsController;
use App\Http\Controllers\ScheduleMonitorController;
use Illuminate\Support\Facades\Route;


Route::prefix("dev")->middleware("is_dev")->group(function(){
    Route::get('/health', HealthCheckResultsController::class)->name('health');
    Route::get('/delete-project', [DeleteProject::class, "deleteProject"])->name('deleteProject');
    Route::delete('/delete-project', [DeleteProject::class, "deleteProjectDelete"])->name('deleteProjectDelete');

    Route::get('/schedule-monitor', [ScheduleMonitorController::class, 'syncSchedule'])->name("dev.syncSchedule");
});
