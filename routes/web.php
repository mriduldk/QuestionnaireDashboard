<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserLocationController;
use App\Http\Controllers\SurveyAnswerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SurveyAdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\SectionAdminController;
use App\Http\Controllers\Admin\QuestionAdminController;
use App\Http\Controllers\Api\SurveyApiController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/adminLogin', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin-login-post', [AdminLoginController::class, 'login'])->name('admin.login-post');
Route::post('/admin-logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::get('/surveys/{survey}', [SurveyApiController::class, 'show']);


Route::middleware(['auth:admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Route::get('/surveys', [SurveyController::class, 'index']);
    // Route::get('/surveys/{id}', [SurveyController::class, 'show']);
    // Route::post('/answers', [AnswerController::class, 'store']);

    Route::resource('surveys', SurveyAdminController::class);
    Route::resource('sections', SectionAdminController::class);
    Route::resource('questions', QuestionAdminController::class);
    Route::resource('users', UserController::class);

    Route::get('/questions/by-section/{section}', [QuestionAdminController::class, 'getBySection']);
    Route::get('/sections/by-survey/{survey}', [SectionAdminController::class, 'getBySurvey']);
    Route::get('/surveys/{survey}/answers', [SurveyAnswerController::class, 'bySurvey'])->name('surveys.answers');
    Route::get('/survey-answers/{id}/export', [SurveyAnswerController::class, 'exportExcel'])->name('survey-answers.export');

    Route::resource('survey-answers', SurveyAnswerController::class)->only(['index', 'show']);

    Route::get('users/{user_id}', [UserController::class, 'show'])->name('admin.users.show');

    Route::get('user-locations', [UserLocationController::class, 'index'])->name('admin.user-locations.map');
    Route::get('user-locations/ajax', [UserLocationController::class, 'ajax'])->name('admin.user-locations.ajax');

});



