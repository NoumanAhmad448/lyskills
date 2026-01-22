<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseEx3Controller;
use App\Http\Controllers\CourseExController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstructorPaymentController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\SayonaraController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

$route = Route::middleware(['web', 'auth']);

if (config("setting.enable_instructor_domain")) {
    $route->domain(config("setting.instructor_domain"));
}
$route->group(function () {

    Route::post('instructor/bank-detail', [InstructorPaymentController::class, 'storeBankPayment'])->name('i_bank_payment');
    Route::post('instructor/paypal-detail', [InstructorPaymentController::class, 'storePaypalPayment'])->name('i_paypal_payment_withdraw');
    Route::post('instructor/payoneer-detail', [InstructorPaymentController::class, 'storePayoneerPayment'])->name('i_payoneer_payment_withdraw');
    Route::post('instructor/jazzcash-detail', [InstructorPaymentController::class, 'storeJazzcashPayment'])->name('i_jazzcash_payment_withdraw');
    Route::post('instructor/easypaisa-detail', [InstructorPaymentController::class, 'storeEasypaisaPayment'])->name('i_easypaisa_payment_withdraw');
});
