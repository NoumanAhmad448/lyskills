<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CourseEx2Controller;
use App\Http\Controllers\CourseEx3Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DescriptionController;
use App\Http\Controllers\ExResController;
use App\Http\Controllers\OtherFilesController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

$route = Route::middleware(['web', 'auth']);

if (config("setting.enable_instructor_domain")) {
    $route->domain(config("setting.instructor_domain"));
}
$route->group(function () {

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


});
