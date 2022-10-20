<?php

use App\Http\Controllers\DeploymentController;
use Illuminate\Support\Facades\Route;

Route::get("/clear-cache", [DeploymentController::class, "clearCache"]);

Route::get("/live-deployment", [DeploymentController::class, "liveDeployment"]);