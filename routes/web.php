<?php

use App\Features\GuestFeatures;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseEx2Controller;
use App\Http\Controllers\CourseEx3Controller;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DescriptionController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ExResController;
use App\Http\Controllers\OtherFilesController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\SayonaraController;
use App\Http\Controllers\AdminFaqController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\BloggerController;
use App\Http\Controllers\BloggerFaqController;
use App\Http\Controllers\BloggerPostController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CreateSubAdminController;
use App\Http\Controllers\InstructorPayment;
use App\Http\Controllers\InstructorPaymentController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\OfflinePaymentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SetttingController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\StoreUserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserAnnController;
use App\Http\Controllers\WithdrawPaymentController;
use App\Http\Livewire\AdminController as LivewireAdminController;
use App\Http\Livewire\BloggerHome;
use App\Http\Livewire\BloggerLoginPanel;
use App\Routes\EmailRoutes;
use App\Routes\GuestRoutes;
use App\Views\GuestView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;


Route::domain(config("app.url"))->post('/back', function () {
    return redirect()->route('index');
})->name('back');

if (GuestFeatures::enableVerifyEmail()) {
    Route::domain(config("app.url"))->get(GuestRoutes::verifyEmail(), function () {
        return view(GuestView::verifyEmailView());
    })->middleware([config("middlewares.auth")])->name(config("names.vn"));

    Route::domain(config("app.url"))->get(GuestRoutes::verifyEmailHash(), function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route(config("names.login"));
    })
        ->middleware([config("middlewares.auth"), config("middlewares.signed")])->name(config("names.vv"));

    Route::domain(config("app.url"))->post(EmailRoutes::emailNotification(), function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', __("messages.ven"));
    })->middleware([config("middlewares.auth"), config("middlwares.th_1_m_6")])->name(config("names.vs"));
}

Route::domain(config("app.url"))->middleware([config("middlewares.auth"), config("middlewares.verified")])->group(function () {

    Route::get('/courses/create/{id}/{course_id}', [CourseController::class, 'index'])
        ->name('courses_instruction');
    Route::post('/courses/create/{id}/{course_id}', [CourseController::class, 'storeCourseDetail'])
        ->name('courses_instructions');

    Route::get('instructor/course/{course_id}/manage/course-structure', [DashboardController::class, 'course_structure'])
        ->name('course_structure');

    Route::get('instructor/course/{course_id}/manage/setup', [DashboardController::class, 'course_setup'])
        ->name('course_setup');

    Route::get('instructor/course/{course_id}/manage/film', [DashboardController::class, 'course_film'])
        ->name('courses_film_edit');

    Route::post('/save-access-duration', [MediaController::class, 'saveAccessDuration'])
        ->name('saveAccessDuration');
});


$route = Route::middleware([config("middlewares.auth"), 'admin', config("middlewares.verified")]);
if (config("setting.enable_admin_domain")) {
    $route->domain(config("setting.admin_domain"));
}

$route->group(function () {


    Route::get('admin/show-post', [AdminPostController::class, 'view'])->name('admin_v_p');
    Route::get('admin/create-post', [AdminPostController::class, 'createPost'])->name('admin_c_p');
    Route::post('admin/create-post', [AdminPostController::class, 'savePost'])->name('admin_s_p');

    Route::post('admin/post/{post}/change-status', [AdminPostController::class, 'changeStatus'])->name('admin_cs_p');
    Route::delete('admin/post/{post}/delete-post', [AdminPostController::class, 'delete'])->name('admin_p_delete');

    Route::get('admin/post/{post}/edit-post', [AdminPostController::class, 'editPost'])->name('admin_edit_p');
    Route::put('admin/post/{post}/update-post', [AdminPostController::class, 'updatePost'])->name('admin_update_p');


    Route::get('admin/show-faq', [AdminFaqController::class, 'view'])->name('admin_v_faq');
    Route::get('admin/create-faq', [AdminFaqController::class, 'createFaq'])->name('admin_c_faq');
    Route::post('admin/create-faq', [AdminFaqController::class, 'saveFaq'])->name('admin_s_faq');

    Route::post('admin/faq/{faq}/change-status', [AdminFaqController::class, 'changeStatus'])->name('admin_cs_faq');
    Route::delete('admin/faq/{faq}/delete-faq', [AdminFaqController::class, 'delete'])->name('admin_faq_delete');

    Route::get('admin/faq/{faq}/edit-faq', [AdminFaqController::class, 'editFaq'])->name('admin_edit_faq');
    Route::put('admin/faq/{faq}/update-faq', [AdminFaqController::class, 'updateFaq'])->name('admin_update_faq');

    Route::get('admin/show-all-medias', [MediaController::class, 'show'])->name('admin_show_medias');

    Route::get('admin/show-popular-courses', [CourseController::class, 'showPC'])->name('s_p_c');

    Route::get('admin/show-featured-courses', [CourseController::class, 'showFC'])->name('s_f_c');

    Route::get('admin/setting/general-setting', [SetttingController::class, 'general_setting'])->name('admin_g_setting');

    Route::get('admin/setting/lms-setting', [SetttingController::class, 'lms_setting'])->name('admin_lms_setting');
    Route::post('admin/setting/lms-setting', [SetttingController::class, 'save_lms_setting'])->name('admin_p_lms_setting');


    Route::get('admin/setting/payment-gateway-setting', [SetttingController::class, 'paymentGateways'])->name('a_payment_gateways');
    Route::post('admin/setting/strip-payment-setting', [SetttingController::class, 'storeStripPayment'])->name('a_strip_payment');
    Route::post('admin/setting/paypal-payment-setting', [SetttingController::class, 'storePaypalPayment'])->name('a_paypal_payment');
    Route::post('admin/setting/jazzcash-payment-setting', [SetttingController::class, 'storeJazzPayment'])->name('a_jazzcash_payment');
    Route::post('admin/setting/easypaisa-payment-setting', [SetttingController::class, 'storeEasypaisaPayment'])->name('a_easypaisa_payment');

    Route::get('admin/setting/offline/payment-gateway-setting', [OfflinePaymentController::class, 'paymentGateways'])->name('a_offline_payment_gateways');
    Route::post('admin/setting/offline/jazzcash-payment-setting', [OfflinePaymentController::class, 'storeJazzPayment'])->name('a_jazzcash_offline_payment');
    Route::post('admin/setting/offline/easypaisa-payment-setting', [OfflinePaymentController::class, 'storeEasypaisaPayment'])->name('a_easypaisa_offline_payment');
    Route::post('admin/setting/offline/other-payment-setting', [OfflinePaymentController::class, 'storeOtherPayment'])->name('a_other_offline_payment');
    Route::post('admin/setting/offline/bank-payment-setting', [OfflinePaymentController::class, 'storeBankPayment'])->name('a_bank_offline_payment');

    Route::get('admin/setting/mimimum-withdraw-setting', [WithdrawPaymentController::class, 'show'])->name('a_w_p_c');
    Route::post('admin/setting/payment/jazzcash-payment-setting', [WithdrawPaymentController::class, 'storeJazzPayment'])->name('a_withdraw_jazz');
    Route::post('admin/setting/payment/easypaisa-payment-setting', [WithdrawPaymentController::class, 'storeEasypaisaPayment'])->name('a_withdraw_easypaisa');
    Route::post('admin/setting/payment/bank-payment-setting', [WithdrawPaymentController::class, 'storeBankPayment'])->name('a_withdraw_bank');
    Route::post('admin/setting/payment/paypal-payment-setting', [WithdrawPaymentController::class, 'storePaypalPayment'])->name('a_withdraw_paypal');

    Route::get('admin/setting/social-account-settings', [SocialController::class, 'show'])->name('social_networks');
    Route::post('admin/setting/facebook-account-settings', [SocialController::class, 'facebook'])->name('social_networks_fb');
    Route::post('admin/setting/google-account-settings', [SocialController::class, 'google'])->name('social_networks_g');
    Route::post('admin/setting/linkedin-account-settings', [SocialController::class, 'linkedin'])->name('social_networks_li');


    Route::get('admin/setting/blogger-setting', [SetttingController::class, 'blog'])->name('blogger-setting');
    Route::post('admin/setting/blogger-setting', [SetttingController::class, 'blogPost'])->name('blogger-setting-post');

    Route::get('admin/courses/change-price/{course}', [CourseController::class, 'changePrice'])->name('admin_change_price');
    Route::patch('admin/courses/change-price/{course}', [CourseController::class, 'changePricePost'])->name('admin_change_price_post');

    Route::get('admin/instructor/instructor-payment', [InstructorPayment::class, 'viewPayment'])->name('i_payment');
    Route::get('admin/courses/payment-history', [InstructorPayment::class, 'paymentHistory'])->name('u_payment');

    Route::get('admin/instructor/view_instructor_detail/{user}', [InstructorPayment::class, 'viewInstructorDetail'])->name('v_i_detail');

    Route::get('admin/create-course-instruction-on-dashboard', [InstructorPayment::class, 'createInfo'])->name('c_info');
    Route::get('admin/show-course-instruction-on-dashboard', [InstructorPayment::class, 'showInfo'])->name('s_info');
    Route::post('admin/create-course-instruction-on-dashboard', [InstructorPayment::class, 'postInfo'])->name('p_info');
    Route::get('admin/{i}/edit-show-course-instruction-on-dashboard', [InstructorPayment::class, 'showEdit'])->name('show_edit');
    Route::put('admin/{i}/edit-course-instruction-on-dashboard', [InstructorPayment::class, 'edit'])->name('____edit');
    Route::post('admin/{i}/delete-course-instruction-on-dashboard', [InstructorPayment::class, 'delete'])->name('____delete');

    Route::get('admin/create-course-user-on-dashboard', [UserAnnController::class, 'createInfo'])->name('c_info_user');
    Route::get('admin/show-course-user-on-dashboard', [UserAnnController::class, 'showInfo'])->name('s_info_user');
    Route::post('admin/create-course-user-on-dashboard', [UserAnnController::class, 'postInfo'])->name('p_info_user');
    Route::get('admin/{i}/edit-show-course-user-on-dashboard', [UserAnnController::class, 'showEdit'])->name('show_edit_user');
    Route::put('admin/{i}/edit-course-user-on-dashboard', [UserAnnController::class, 'edit'])->name('____edit_user');
    Route::post('admin/{i}/delete-course-user-on-dashboard', [UserAnnController::class, 'delete'])->name('____delete_user');

    Route::get('admin/show-bloggers', [BloggerController::class, 'show'])->name('show_blogger___');

    Route::put('admin/update-admin-profile/{user}', [CreateSubAdminController::class, 'updateAdmin'])->name('update_admins');
    Route::get('admin/show-admins', LivewireAdminController::class)->name('show_sub_admins');
});

Route::get('blogger-login', BloggerLoginPanel::class)->name('blogger-login');
Route::post('blogger-login', [BloggerController::class, 'login'])->name('blogger_login_post');

Route::prefix('blogger')->middleware(['blogger', config("middlewares.auth"), config("middlewares.verified")])->group(function () {
    Route::get('/', BloggerHome::class)->name('blogger_home');

    Route::get('show-post', [BloggerPostController::class, 'view'])->name('blogger_v_p');
    Route::get('create-post', [BloggerPostController::class, 'createPost'])->name('blogger_c_p');
    Route::post('create-post', [BloggerPostController::class, 'savePost'])->name('blogger_s_p');

    Route::post('post/{post}/change-status', [BloggerPostController::class, 'changeStatus'])->name('blogger_cs_p');
    Route::delete('post/{post}/delete-post', [BloggerPostController::class, 'delete'])->name('blogger_p_delete');

    Route::get('post/{post}/edit-post', [BloggerPostController::class, 'editPost'])->name('blogger_edit_p');
    Route::put('post/{post}/update-post', [BloggerPostController::class, 'updatePost'])->name('blogger_update_p');

    Route::get('show-faq', [BloggerFaqController::class, 'view'])->name('blogger_v_faq');
    Route::get('create-faq', [BloggerFaqController::class, 'createFaq'])->name('blogger_c_faq');
    Route::post('create-faq', [BloggerFaqController::class, 'saveFaq'])->name('blogger_s_faq');

    Route::post('faq/{faq}/change-status', [BloggerFaqController::class, 'changeStatus'])->name('blogger_cs_faq');
    Route::delete('faq/{faq}/delete-faq', [BloggerFaqController::class, 'delete'])->name('blogger_faq_delete');

    Route::get('faq/{faq}/edit-faq', [BloggerFaqController::class, 'editFaq'])->name('blogger_edit_faq');
    Route::put('faq/{faq}/update-faq', [BloggerFaqController::class, 'updateFaq'])->name('blogger_update_faq');

    Route::get('blogger-logout', [BloggerFaqController::class, 'logout'])->name('b_logout');
});


Route::domain(config("app.url"))->middleware([config("middlewares.verified"), config("middlewares.auth")])->group(function () {


    Route::delete('student/course/remove-from-wish-list/{slug}', [StudentController::class, 'removeFromWishlist'])->name('remove-wishlist-course');
    Route::get('student/my-learnings', [StudentController::class, 'myLearning'])->name('my-learning-courses-list');
    Route::get('student/my-cart', [StudentController::class, 'myCart'])->name('mycart-student');
    Route::get('student/notification', [StudentController::class, 'getNotify'])->name('get-notify-by-instructor');
    Route::get('student/send-message', [StudentController::class, 'sendMsg'])->name('fa-msg-to-laoshi');
    Route::get('student/saved-payment-detail', [StudentController::class, 'savedPaymentDetail'])->name('saveQian');
    Route::get('student/purchase-history', [StudentController::class, 'maiHistory'])->name('maiHistory');

    Route::get('student/contact-with-instructor', [CourseEx3Controller::class, 'contactIns'])->name('con-ins');
    Route::post('student/contact-with-instructor', [CourseEx3Controller::class, 'contactInsPost'])->name('con-ins-post');

    Route::get('student/contacts-instructor', [CourseEx2Controller::class, 'chatIns'])->name('chat_w_i');
});

Route::domain(config("app.url"))->middleware([config("middlewares.verified"), config("middlewares.auth")])->group(function () {
    Route::post('student/course/coupon', [CourseEx2Controller::class, 'coupon'])->name('coupon');
    Route::post('student/course/enroll-now/{course}', [CourseEx2Controller::class, 'enrollNow'])->name('enroll-now');
    Route::delete('student/course/enroll-now/{course}', [CourseEx2Controller::class, 'un_enrollNow'])->name('un-enroll-now');
});


Route::domain(config("app.url"))->middleware([config("middlewares.auth"), 'admin', config("middlewares.verified")])->prefix('admin')->group(function () {
    Route::post('payment/to/instructor/by-admin', [PaymentController::class, 'sendEmailToInstructor'])->name('send-email-to-ins');
    Route::get('student/enrollements', [PaymentController::class, 'newEnrollment'])->name('course-enrollment');
    Route::get('user-in-courses-enrollment/{course}', [PaymentController::class, 'enrollment'])->name('enrollment-user');
    Route::get('store-users', [StoreUserController::class, 'storeUser']);
});


// Route::get('/testing-paypal-integration', [PaypalController::class, 'testingPaypal']);
Route::domain(config("app.url"))->middleware(config("middlewares.auth"))->post('/paypal-integration/{slug}', [PaypalController::class, 'testingPaypalPost'])->name('PaypalPost');
// Route::get('cancel-payment', [PaypalController::class, 'paymentCancel'])->name('cancel.payment');
Route::domain(config("app.url"))->middleware(config("middlewares.auth"))->get('payment-success', [PaypalController::class, 'paymentSuccess'])->name('success.payment');



// Include route files
require __DIR__ . '/dev_routes.php';
require __DIR__ . '/super_admin_routes.php';
require __DIR__ . '/course_ex_controller_routes.php';
require __DIR__ . '/course_ex_controller_routes.php';
require __DIR__ . '/easypaisa_controller.php';
require __DIR__ . '/instructor_auth_controller.php';
require __DIR__ . '/admin_controller.php';
require __DIR__ . '/home_controller.php';
require __DIR__ . '/user_controller.php';
require __DIR__ . '/admin_users.php';
require __DIR__ . '/admin_page.php';
require __DIR__ . '/cron_job.php';
require __DIR__ . '/assignment.php';
require __DIR__ . '/categories_controller.php';

if (trim(config('app.env')) == config("setting.roles.dev")) {
    URL::forceScheme(config("setting.http"));
}
