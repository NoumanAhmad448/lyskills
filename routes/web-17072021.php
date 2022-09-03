<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\HomeController;
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
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminFaqController;
use App\Http\Controllers\AdminPageController;
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
use App\Http\Controllers\SubCategories;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SetttingController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\StoreUserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserAnnController;
use App\Http\Controllers\WithdrawPaymentController;
use App\Http\Livewire\AdminController as LivewireAdminController;
use App\Http\Livewire\BloggerHome;
use App\Http\Livewire\BloggerLoginPanel;
use App\Http\Livewire\CreateAdmin as CreateAdminByAdmin;
use App\Http\Livewire\CreateBlogger;
use App\Http\Livewire\EditAdmin;
use Illuminate\Http\Request;
use App\Http\Controllers\EasypaisaController;

// Route::get('go-live-with-nouman', [HomeController::class, 'aritsanLive']);

Route::post('/back', function(){
    return redirect()->route('index');
})->name('back');

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('post/{slug}', [HomeController::class, 'post'])->name('public_posts');
Route::get('posts', [HomeController::class, 'posts'])->name('all_public_posts');
Route::get('page/{slug}', [HomeController::class, 'page'])->name('public_pages');
Route::get('faq/{slug}', [HomeController::class, 'faq'])->name('public_faqs');
Route::get('faqs', [HomeController::class, 'faqs'])->name('public_faq');

// social login
Route::get('/login/google', [SocialController::class, 'googleVerification'])->name('google-login');
Route::get('/google/callback',[SocialController::class, 'googleLogin'] );

Route::get('/login/facebook', [SocialController::class, 'facebookVerification'])->name('fb-login');
Route::get('/facebook/callback',[SocialController::class, 'facebookLogin'] );

Route::get('/login/linkedin', [SocialController::class, 'linkedinVerification'])->name('li-login');
Route::get('/linkedin/callback',[SocialController::class, 'linkedinLogin'] );

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request)
{
    $request->fulfill();    
    return redirect()->route('login');
})
->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification email has been sent. please check your email address');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', 
[DashboardController::class, 'index']
)->name('dashboard');

Route::middleware(['auth','verified'])->group(function () {
  

    Route::get('/courses/create/{id}/{course_id}', [CourseController::class, 'index'])
        ->name('courses_instruction');
        
    Route::post('/courses/create/{id}/{course_id}', [CourseController::class, 'storeCourseDetail'])
    ->name('courses_instructions');

        
    Route::post('/create_course', [CourseController::class, 'createCourse'])
    ->name('create_course');


    Route::get('/course/{course_id}/manage/goals', [DashboardController::class, 'show'])
        ->name('courses_dashboard');
        
    Route::post('/course/{course_id}/manage/goals', [DashboardController::class, 'save_record'])
    ->name('courses_dashboard_post');
        
    Route::get('instructor/course/{course_id}/manage/course-structure', [DashboardController::class, 'course_structure'])
        ->name('course_structure');

    Route::get('instructor/course/{course_id}/manage/setup', [DashboardController::class, 'course_setup'])
        ->name('course_setup');

    Route::get('instructor/course/{course_id}/manage/film', [DashboardController::class, 'course_film'])
        ->name('courses_film_edit');

    Route::get('instructor/course/{course_id}/manage/curriculum', [DashboardController::class, 'course_curriculum'])
        ->name('courses_curriculum');

    Route::post('instructor/course/{course_id}/manage/section_title', [DashboardController::class, 'course_curriculum_post'])
        ->name('courses_curriculum_post');
    
    Route::post('instructor/course/{course_id}/manage/lec_name', [DashboardController::class, 'lec_name_post'])
    ->name('lec_name_post');

    
    Route::post('instructor/course/{course_id}/manage/lec_name_edit', [DashboardController::class, 'lec_name_edit_post'])
    ->name('lec_name_edit_post');

    Route::post('instructor/course/{course_id}/manage/lec_name_edit', [DashboardController::class, 'lec_name_edit_post'])
    ->name('lec_name_edit_post');
    
    
    Route::delete('instructor/course/{course_id}/manage/course_delete', [DashboardController::class, 'course_delete'])
    ->name('course_delete');
    
    Route::delete('instructor/course/{course_id}/{lecture_id}/manage/lecture_delete', [DashboardController::class, 'lecture_delete'])
    ->name('lecture_delete');


    Route::post('instructor/course/{course_id}/{section_id}/manage/section_delete', [DashboardController::class, 'section_delete'])
    ->name('section_delete');


    Route::post('instructor/course/{course_id}/{lecture_id}/upload_video', [VideoController::class, 'upload_video'])
    ->name('upload_video');

    Route::delete('instructor/course/{course_id}/{media_id}/delete_video', [VideoController::class, 'delete_video'])
    ->name('delete_video');

    Route::post('instructor/course/{course_id}/{media_id}/edit_video', [VideoController::class, 'edit_video'])
    ->name('edit_video1');

    Route::post('i/video/course/{course_id}/{media_id}/e_vid', [VideoController::class, 'edit_video'])
    ->name('edit_video');


    Route::post('instructor/course/{course_id}/{lec_id}/add_descrption', [DescriptionController::class, 'add_desc'])
    ->name('add_desc');

    
    Route::post('instructor/lec/{lec_id}/uploadVideo', [DashboardController::class, 'upload_vid_res'])
    ->name('upload_vid_res');


    Route::delete('instructor/lec/{lec_id}/delete_video', [VideoController::class, 'delete_uploaded_video'])
    ->name('delete_uploaded_video');
    

    Route::post('instructor/lec/{lec_id}/article', [ArticleController::class, 'article'])
    ->name('article');


    Route::post('instructor/lec/{lec_id}/external_resource', [ExResController::class, 'link'])
    ->name('ex_res');

    Route::post('instructor/lec/{lec_id}/other_files', [OtherFilesController::class, 'index'])
    ->name('other_files');

    Route::delete('instructor/lec/{lec_id}/delete_file', [OtherFilesController::class, 'delete'])
    ->name('delete_file');

    Route::post('instructor/file/{file_id}', [OtherFilesController::class, 'prev_file'])
    ->name('prev_file');

    Route::post('instructor/{course}/assigment', [AssignmentController::class, 'assign'])
    ->name('assign');

    Route::post('instructor/{assign}/update', [AssignmentController::class, 'update'])
    ->name('update_assign');
    
    Route::delete('instructor/{assign}/delete', [AssignmentController::class, 'delete'])
    ->name('delete_assign');
    
    Route::post('instructor/assignment/{assign}/add-description', [AssignmentController::class, 'addDesc'])
    ->name('add_assign_desc');

    Route::post('instructor/{assign}/add-ass', [AssignmentController::class, 'addAss'])
    ->name('add_ass');

    Route::post('instructor/{assign}/add-solution', [AssignmentController::class, 'addSol'])
    ->name('add_sol');

    Route::delete('instructor/{assign}/delete_file', [AssignmentController::class, 'deleteFile'])
    ->name('delete_ass_file');

    Route::post('instructor/{file_id}/file_download', [AssignmentController::class, 'download'])
    ->name('prev_ass_file');

    Route::delete('instructor/assignment/{assign}/solution/delete_file', [AssignmentController::class, 'solFileDel'])
    ->name('delete_sol_file');

    Route::post('instructor/assignment/{file_id}/solution/file_download', [AssignmentController::class, 'solDown'])
    ->name('prev_sola_file');

    Route::post('instructor/{course}/quiz', [QuizController::class, 'quiz'])
    ->name('quiz');
    Route::post('instructor/quiz/{quiz}/update', [QuizController::class, 'update'])
    ->name('update_quiz');
    
    Route::delete('instructor/quiz/{quiz}/delete', [QuizController::class, 'delete'])
    ->name('delete_quiz');
    
    Route::post('instructor/quiz/{quiz}/add-description', [QuizController::class, 'addDesc'])
    ->name('add_quiz_desc');

    Route::post('instructor/quiz/{quiz}/add-quiz', [QuizController::class, 'addQuiz'])
    ->name('add_quizzs');

    Route::post('instructor/quiz/{quizzes}/edit-quizzes', [QuizController::class, 'editQuizzes'])
    ->name('edit_quizzes');


    Route::put('instructor/quiz/{quizzes}/update_quiz', [QuizController::class, 'updateQuiz'])
    ->name('update_quizzes');

    Route::delete('instructor/quiz/{quizzes}/delete-quizzes', [QuizController::class, 'deleteQuizzes'])
    ->name('del_quizzes');

    Route::get('instructor/course/{course}/course-landing', [LandingPageController::class, 'landing_page'])
    ->name('landing_page');


    Route::post('instructor/course/{course}/course-landing', [LandingPageController::class, 'store_landing_page'])
    ->name('landing_page_post');


    Route::post('instructor/course/{course}/course-image', [LandingPageController::class, 'course_img'])
    ->name('course_img');

    Route::post('instructor/course/{course}/course-video', [LandingPageController::class, 'course_vid'])
    ->name('course_vid');


    Route::get('instructor/course/{course}/pricing', [PricingController::class, 'pricing'])
    ->name('pricing');

    Route::post('instructor/course/{course}/pricing', [PricingController::class, 'savePricing'])
    ->name('pricingPost');

    Route::get('instructor/course/{course}/promotion', [PromotionController::class, 'promotion'])
    ->name('promotion');

    Route::post('instructor/course/{course}/coupon', [PromotionController::class, 'saveCoupon'])
    ->name('saveCoupon');
    
    Route::post('instructor/coupon/{promotion}/update_coupon', [PromotionController::class, 'updateCoupon'])
    ->name('updateCoupon');
    
    Route::delete('instructor/coupon/{promotion}/delete_coupon', [PromotionController::class, 'deleteCoupon'])
    ->name('delete_coupon');

    Route::get('instructor/course/{course}/final_message', [SayonaraController::class, 'sayonara'])
    ->name('zaijian');

    Route::post('instructor/course/{course}/final_message', [SayonaraController::class, 'storeSayonara'])
    ->name('zaijianPost');

    Route::post('instructor/course/{course}/submit-course', [SayonaraController::class, 'submitCourse'])
    ->name('submitCourse');

    Route::post('instructor/course/{course}/upload-bulk-loader', [VideoController::class, 'uploadBulkLoader'])
    ->name('bulk_loader');
   
    Route::get('instructor/course/{course}/setting-course-status', [CourseController::class, 'setting'])
    ->name('setting');

    Route::post('instructor/course/{course}/setting-course-status', [CourseController::class, 'PostSetting'])
    ->name('post_setting');

    Route::post('instructor/course/{course}/setting-delete-course', [CourseController::class, 'delCourseSetting'])
    ->name('del-course_setting');
    
    Route::post('instructor/course/{course}/change-the-course-url', [CourseController::class, 'changeURL'])
    ->name('course-change-url');
   
});


Route::get('/admin',[AdminController::class, 'admin_panel'])->name('admin');

Route::post('/', [AdminController::class, 'login'])->name('admin');

Route::get('/index/index', [AdminController::class, 'index'])->middleware('admin')->name('a_home');

Route::get('/user_logout', [HomeController::class, 'logout'])->name('logout');
Route::post('/user_logout', [HomeController::class, 'logout'])->name('logout_post');

Route::middleware(['auth', 'admin','verified'])->group(function () {
    Route::get('/logout', [AdminController::class, 'logout'])->name('a_logout');
    Route::get('/course-history-delete', [AdminController::class, 'courseHistory'])->name('course_del');
    Route::get('/users', [UserController::class, 'index'])->name('a_users');
    Route::get('/edit-users/{user}', [UserController::class, 'edit'])->name('a_e_users');
    Route::put('/update-users/{user}', [UserController::class, 'update'])->name('a_u_users');
    Route::delete('/delete-users/{user}', [UserController::class, 'delete'])->name('a_d_users');
    
    Route::post('/sorting-users', [UserController::class, 'sortingUser'])->name('sorting_users');
    Route::get('/sorting-users', [UserController::class, 'index']);
    
    Route::post('/search-users', [UserController::class, 'searchUser'])->name('search_users');
    Route::get('/search-users', [UserController::class, 'index']);
    
    Route::get('/all-assignments', [AdminController::class, 'getAss'])->name('a-asses');
    
    Route::post('/all-assignments-sorting', [AdminController::class, 'assSorting'])->name('a_a_sorting');
    Route::get('/all-assignments-sorting', [AdminController::class, 'getAss']);
    
    Route::post('/all-assignments-searching', [AdminController::class, 'searching'])->name('a_a_searching');
    Route::get('/all-assignments-searching', [AdminController::class, 'getAss']);
    
    Route::get('/get-courses', [AdminController::class, 'viewCourse'])->name('a_courses');
    Route::get('/get-draft-courses', [AdminController::class, 'draftCourse'])->name('draft_course');
    Route::get('/get-published-courses', [AdminController::class, 'publishedCourse'])->name('p_courses');
    Route::post('/all-courses-sorting', [AdminController::class, 'courseSorting'])->name('a_c_sorting');
    Route::get('/all-courses-sorting', [AdminController::class, 'viewCourse']);
    
    Route::post('/all-courses-searching', [AdminController::class, 'courseSearching'])->name('a_c_searching');
    Route::get('/all-courses-searching', [AdminController::class, 'viewCourse']);
    
    Route::get('admin/show-post', [AdminPostController::class, 'view'])->name('admin_v_p');
    Route::get('admin/create-post', [AdminPostController::class, 'createPost'])->name('admin_c_p');
    Route::post('admin/create-post', [AdminPostController::class, 'savePost'])->name('admin_s_p');
    
    Route::post('admin/post/{post}/change-status', [AdminPostController::class, 'changeStatus'])->name('admin_cs_p');
    Route::delete('admin/post/{post}/delete-post', [AdminPostController::class, 'delete'])->name('admin_p_delete');
    
    Route::get('admin/post/{post}/edit-post', [AdminPostController::class, 'editPost'])->name('admin_edit_p');
    Route::put('admin/post/{post}/update-post', [AdminPostController::class, 'updatePost'])->name('admin_update_p');
    
    Route::get('admin/show-page', [AdminPageController::class, 'view'])->name('admin_v_page');
    Route::get('admin/create-page', [AdminPageController::class, 'createPage'])->name('admin_c_page');
    Route::post('admin/create-page', [AdminPageController::class, 'savePage'])->name('admin_s_page');
    
    Route::post('admin/page/{page}/change-status', [AdminPageController::class, 'changeStatus'])->name('admin_cs_page');
    Route::delete('admin/page/{page}/delete-page', [AdminPageController::class, 'delete'])->name('admin_page_delete');
    
    Route::get('admin/page/{page}/edit-page', [AdminPageController::class, 'editPage'])->name('admin_edit_page');
    Route::put('admin/page/{page}/update-page', [AdminPageController::class, 'updatePage'])->name('admin_update_page');
    
    Route::get('admin/show-faq', [AdminFaqController::class, 'view'])->name('admin_v_faq');
    Route::get('admin/create-faq', [AdminFaqController::class, 'createFaq'])->name('admin_c_faq');
    Route::post('admin/create-faq', [AdminFaqController::class, 'saveFaq'])->name('admin_s_faq');
    
    Route::post('admin/faq/{faq}/change-status', [AdminFaqController::class, 'changeStatus'])->name('admin_cs_faq');
    Route::delete('admin/faq/{faq}/delete-faq', [AdminFaqController::class, 'delete'])->name('admin_faq_delete');
    
    Route::get('admin/faq/{faq}/edit-faq', [AdminFaqController::class, 'editFaq'])->name('admin_edit_faq');
    Route::put('admin/faq/{faq}/update-faq', [AdminFaqController::class, 'updateFaq'])->name('admin_update_faq');
    
    Route::get('admin/categories', [CategoriesController::class, 'viewCategories'])->name('admin_view_categories');
    Route::get('admin/main-categories', [CategoriesController::class, 'mainCategories'])->name('admin_main_categories');
    Route::get('admin/sub-categories', [CategoriesController::class, 'subCategories'])->name('admin_sub_categories');
    
    Route::get('admin/create-main-categories', [CategoriesController::class, 'createMainCategories'])->name('admin_create_main_c');
    Route::post('admin/store-main-categories', [CategoriesController::class, 'storeMainCategories'])->name('admin_store_main_c');
    
    Route::get('admin/edit-main-categories/{c}', [CategoriesController::class, 'storeEditCategories'])->name('admin_edit_main_c');
    Route::patch('admin/update-main-categories/{c}', [CategoriesController::class, 'storeUpdateCategories'])->name('admin_update_main_c');
    
    Route::delete('admin/delete-main-categories/{category}', [CategoriesController::class, 'storeDeleteCategories'])->name('admin_delete_main_c');
    
    Route::get('admin/create-sub-categories', [SubCategories::class, 'createSubCategories'])->name('admin_create_sub_c');
    Route::post('admin/store-sub-categories', [SubCategories::class, 'storeSubCategories'])->name('admin_store_sub_c');
    
    Route::get('admin/edit-sub-categories/{c}', [SubCategories::class, 'storeEditCategories'])->name('admin_edit_sub_c');
    Route::patch('admin/update-sub-categories/{c}', [SubCategories::class, 'storeUpdateCategories'])->name('admin_update_sub_c');
    
    Route::delete('admin/delete-sub-categories/{category}', [SubCategories::class, 'storeDeleteCategories'])->name('admin_delete_sub_c');
    
    Route::get('admin/show-all-medias', [MediaController::class, 'show'])->name('admin_show_medias');

    Route::post('admin/change-course-status', [CourseController::class, 'changeStatus'])->name('change_course_status');
    
    Route::get('admin/show-popular-courses', [CourseController::class, 'showPC'])->name('s_p_c');
    
    Route::get('admin/show-featured-courses', [CourseController::class, 'showFC'])->name('s_f_c');

    Route::get('admin/setting/general-setting', [SetttingController::class, 'general_setting'])->name('admin_g_setting');

    Route::get('admin/setting/lms-setting', [SetttingController::class, 'lms_setting'])->name('admin_lms_setting');
    Route::post('admin/setting/lms-setting', [SetttingController::class, 'save_lms_setting'])->name('admin_p_lms_setting');
    
    Route::get('admin/password/change-password', [AdminController::class, 'changePassword'])->name('admin_change_pass');
    Route::patch('admin/password/change-password', [AdminController::class, 'changePasswordP'])->name('admin_p_change_pass');    
    
    Route::get('admin/setting/payment-share-setting', [AdminController::class, 'sharePayment'])->name('a_share_payment');
    Route::post('admin/setting/payment-share-setting', [AdminController::class, 'sharePostPayment'])->name('a_p_share_payment');
    
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
        
    Route::get('admin/courses/new-courses', [CourseController::class, 'newCourse'])->name('i_new_courses');
    
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

    Route::get('admin/create-bloggers', CreateBlogger::class)->middleware('super_admin')->name('create_blogger___');
    Route::post('admin/post-bloggers', [BloggerController::class,'store_blogger'])->middleware('super_admin')->name('store_blogger___');
    Route::put('admin/create-bloggers/{user}', [BloggerController::class, 'updateBlogger'])->middleware('super_admin')->name('update_blogger___');
    Route::get('admin/show-bloggers', [BloggerController::class, 'show'])->name('show_blogger___');
    Route::get('admin/edit-bloggers/{user}', [BloggerController::class, 'edit'])->middleware('super_admin')->name('edit_blogger___');
    Route::delete('admin/delete-bloggers/{user}', [BloggerController::class, 'delete'])->middleware('super_admin')->name('delete_blogger___');
    
    Route::get('admin/create-sub-admins', CreateAdminByAdmin::class)->middleware('super_admin')->name('create_admin');
    Route::post('admin/post-admins', [CreateSubAdminController::class,'storeSubAdmin'])->middleware('super_admin')->name('store_admin');
    Route::put('admin/update-admin-profile/{user}', [CreateSubAdminController::class, 'updateAdmin'])->name('update_admins');
    Route::get('admin/show-admins', LivewireAdminController::class)->name('show_sub_admins');
    Route::get('admin/edit-admin/{user}', EditAdmin::class)->middleware('super_admin')->name('edit_admin___');
    Route::delete('admin/delete-admin/{user}', [BloggerController::class, 'delete'])->middleware('super_admin')->name('delete_admin___');    

    Route::get('admin/instructor-earning-detail/{id}', [AdminController::class, 'getInsDetailedEaning'])->name('total-earning-detail');    
    
});

Route::get('blogger-login', BloggerLoginPanel::class)->name('blogger-login');
Route::post('blogger-login', [BloggerController::class, 'login'])->name('blogger_login_post');

Route::prefix('blogger')->middleware(['blogger', 'auth','verified'])->group(function () {
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

Route::get('categories/{category}', [CategoriesController::class, 'showCategory'])->name('user-categories');
Route::get('course/{slug}', [CourseController::class, 'showCourse'])->name('user-course');
Route::get('show-all-courses', [CourseController::class, 'showAllCourses'])->name('show-all-courses');



Route::middleware(['verified','auth'])->group(function () {
    
    Route::get('Instructor/instructor-profile', [ProfileController::class, 'getProfile'])->name('i-profile');
    Route::post('instructor-profile', [ProfileController::class, 'saveProfile'])->name('i-profile-post');
    
    Route::get('instructor/instructor-payment', [InstructorPaymentController::class, 'paymentGateways'])->name('i-payment-setting');
    Route::post('instructor/bank-detail', [InstructorPaymentController::class, 'storeBankPayment'])->name('i_bank_payment');
    Route::post('instructor/paypal-detail', [InstructorPaymentController::class, 'storePaypalPayment'])->name('i_paypal_payment_withdraw');
    Route::post('instructor/payoneer-detail', [InstructorPaymentController::class, 'storePayoneerPayment'])->name('i_payoneer_payment_withdraw');
    Route::post('instructor/jazzcash-detail', [InstructorPaymentController::class, 'storeJazzcashPayment'])->name('i_jazzcash_payment_withdraw');
    Route::post('instructor/easypaisa-detail', [InstructorPaymentController::class, 'storeEasypaisaPayment'])->name('i_easypaisa_payment_withdraw');        
    
    Route::post('student/wish-list-courses/{slug}', [StudentController::class, 'wishlistCourse'])->name('wishlist-course-post');        
    Route::get('student/wish-list-courses', [StudentController::class, 'getWishlistCourse'])->name('get-wishlist-course');        
    Route::delete('student/course/remove-from-wish-list/{slug}', [StudentController::class, 'removeFromWishlist'])->name('remove-wishlist-course');        
    Route::get('student/my-learning', [StudentController::class, 'myLearning'])->name('my-learning-courses-list');        
    Route::get('student/my-cart', [StudentController::class, 'myCart'])->name('mycart-student');        
    Route::get('student/notification', [StudentController::class, 'getNotify'])->name('get-notify-by-instructor');        
    Route::get('student/send-message', [StudentController::class, 'sendMsg'])->name('fa-msg-to-laoshi');        
    Route::get('student/saved-payment-detail', [StudentController::class, 'savedPaymentDetail'])->name('saveQian');        
    Route::get('student/purchase-history', [StudentController::class, 'maiHistory'])->name('maiHistory');    
    Route::get('course/{slug}/video/uploads/{video}', [CourseController::class, 'showVideo'])->name('video-page');  
    
    Route::get('courses/public-announcement', [CourseController::class, 'publicAnn'])->name('public-ann');  
    Route::post('courses/public-announcement', [CourseController::class, 'publicAnnPost'])->name('public-ann-post');  
        
    Route::get('student/contact-with-instructor', [CourseController::class, 'contactIns'])->name('con-ins');  
    Route::post('student/contact-with-instructor', [CourseController::class, 'contactInsPost'])->name('con-ins-post');  
    
    Route::get('student/contacts-instructor', [CourseController::class, 'chatIns'])->name('chat_w_i');  
    Route::get('student/email-to-instructor', [CourseController::class, 'emailToIns'])->name('email_to_ins');  
    Route::post('student/email-to-instructor', [CourseController::class, 'emailToInsPost'])->name('email_to_ins_post');  
    
    Route::get('course/{slug}/available-payment-methods', [PaymentController::class, 'availablePayMe'])->name('a_payment_methods');  
    Route::get('course/{slug}/payment-with-credit-card', [PaymentController::class, 'creditPayment'])->name('credit_card_payment');  
    Route::post('course/{slug}/payment-with-credit-card', [PaymentController::class, 'creditPaymentPost'])->name('credit_card_pay_post');  
    
    Route::get('student/payment-history', [PaymentController::class, 'paymentHis'])->name('pay_his');  
    Route::get('instructor/purchase-history', [PaymentController::class, 'purHis'])->name('purHis');  
    
    Route::get('student/my-learning', [CourseController::class, 'myLearning'])->name('myLearning');  
    Route::post('student/offline-payment', [CourseController::class, 'offlinePayment'])->name('offline-payment');  
    Route::get('student/get-certificate', [CourseController::class, 'getCerti'])->name('getCerti');  
    // Route::get('student/get-certificate', [CourseController::class, 'getCerti'])->name('getCerti');  
    Route::post('crop-image-upload', [ProfileController::class,'uploadCropImage'])->name('upload_profile');
    
});


Route::middleware(['auth', 'admin','verified'])->group(function () {
    Route::get('send-email', [AdminController::class, 'sendEmail'])->name('a-send-email');
    Route::post('send-email', [AdminController::class, 'sendEmailPost'])->name('a-p-send-email');
    
    Route::get('admin/new-offline-enrollment', [AdminController::class, 'nEn'])->name('n_en');
    Route::post('admin/new-offline-enrollment/user/{user}/course/{course}', [AdminController::class, 'nEnP'])->name('n_en_p');
    
});

Route::get('contact-us', [HomeController::class, 'contactUs'])->name('contact-us');
Route::post('contact-us', [HomeController::class, 'contactUsPost'])->name('contact-us-post');

Route::post('ckeditor/upload', [HomeController::class, 'upload'])->name('ckeditor.upload');
// Route::get('test', function(){
    //     return view('testing');    
    // });
Route::post('get-search', [HomeController::class, 'getSearch'])->name('get-search');
Route::post('course-search', [HomeController::class, 'userSearch'])->name('c-search-page');
Route::get('show-search-course/{keyword}', [HomeController::class, 'showSearchCourse'])->name('s-search-page');



Route::middleware(['verified','auth'])->group(function () {
    Route::post('student/course/coupon', [CourseController::class, 'coupon'])->name('coupon');
    Route::post('student/course/enroll-now/{course}', [CourseController::class, 'enrollNow'])->name('enroll-now');
});



Route::middleware(['auth', 'admin','verified'])->prefix('admin')->group(function () {
    Route::post('payment/to/instructor/by-admin', [PaymentController::class, 'sendEmailToInstructor'])->name('send-email-to-ins');
    Route::get('student/enrollements', [PaymentController::class, 'newEnrollment'])->name('course-enrollment');
    Route::get('user-in-courses-enrollment/{course}', [PaymentController::class, 'enrollment'])->name('enrollment-user');
    Route::get('store-users', [StoreUserController::class, 'storeUser']);
});


// Route::get('/testing-paypal-integration', [PaypalController::class, 'testingPaypal']);
Route::middleware('auth')->post('/paypal-integration/{slug}', [PaypalController::class, 'testingPaypalPost'])->name('PaypalPost');
// Route::get('cancel-payment', [PaypalController::class, 'paymentCancel'])->name('cancel.payment');
Route::middleware('auth')->get('payment-success', [PaypalController::class, 'paymentSuccess'])->name('success.payment');


Route::middleware('auth')->post('rating-course', [CourseController::class, 'ratingCourse'])->name('rating-course');

Route::middleware('auth')->get('create-pdf-file', [CourseController::class, 'createPdf'])->name('create-pdf');

Route::middleware('auth')->get('download-certificate/{course_name}', [CourseController::class, 'downloadCert'])->name('down-cert');


Route::post('e/{course_id}/{media_id}/edit_video', [VideoController::class, 'edit_video'])->name('e_video');


Route::get('get-many-roles', [HomeController::class, 'getManyRoles']);

Route::middleware('auth')->get('get-currency-exchange', [EasypaisaController::class, 'getPayment'])->name('get-easy-p');
Route::middleware('auth')->get('get-paid-via-easypay', [EasypaisaController::class, 'getEasypay'])->name('get-easy-pay');
Route::middleware('auth')->get('easypaisa-initiate-request/{course}', [EasypaisaController::class, 'getStarted'])->name('haji-me');
Route::middleware('auth')->post('get-paid-via-easypay', [EasypaisaController::class, 'getHashKeyEn'])->name('get-easy-pay-enc');
Route::middleware('auth')->get('get-token-via-easypay', [EasypaisaController::class, 'getEasypayToken'])->name('get-token-pay');








