<?php

use App\Http\Controllers\EasypaisaController;
use Illuminate\Support\Facades\Route;

Route::domain(config("app.url"))->group(function () {

    Route::middleware('auth')->get('get-currency-exchange', [EasypaisaController::class, 'getPayment'])->name('get-easy-p');
    Route::middleware('auth')->get('get-paid-via-easypay', [EasypaisaController::class, 'getEasypay'])->name('get-easy-pay');
    Route::middleware('auth')->get('easypaisa-initiate-request/{course}/with-nouman/{randomtoken}', [EasypaisaController::class, 'getStarted'])->name('haji-me');
    Route::middleware('auth')->post('get-paid-via-easypay', [EasypaisaController::class, 'getHashKeyEn'])->name('get-easy-pay-enc');
    Route::middleware('auth')->get('get-token-via-easypay', [EasypaisaController::class, 'getEasypayToken'])->name('get-token-pay');
});
