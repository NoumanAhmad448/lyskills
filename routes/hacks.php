<?php

use App\Http\Controllers\HacksController;
use Illuminate\Support\Facades\Route;

Route::domain(config("app.url"))->get("/change-config", [HacksController::class, "changeConfig"]);