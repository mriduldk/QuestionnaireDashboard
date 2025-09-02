<?php

use App\Http\Controllers\Admin\BlockController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\SubDivisionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserLocationController;
use App\Http\Controllers\Admin\VcdcController;
use App\Http\Controllers\SurveyAnswerController;
use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SurveyAdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\SectionAdminController;
use App\Http\Controllers\Admin\QuestionAdminController;
use App\Http\Controllers\Api\SurveyApiController;
use App\Http\Controllers\CallLetterController;
use App\Http\Controllers\Admin\SurveySectionController;


/*Route::get('/', function () {
    return view('welcome');
});*/


Route::get('/privacyPolicy', function () {
    return view('privacyPolicy');
});
Route::get('/termsAndCondition', function () {
    return view('termsAndCondition');
});

Route::post('/track-visitor', [VisitorController::class, 'index']);
Route::get('/visitor-count', [VisitorController::class, 'trackVisitor']);


Route::get('/adminLogin', [AdminLoginController::class, 'showLoginForm'])->name('login');
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
    Route::resource('districts', DistrictController::class);
    Route::resource('sub-divisions', SubDivisionController::class);
    Route::resource('blocks', BlockController::class);
    Route::resource('vcdcs', VcdcController::class);
    Route::resource('survey-sections', SurveySectionController::class);

    Route::get('/api/sub-divisions/{district}', [LocationController::class, 'getSubDivisions']);
    Route::get('/api/blocks/{subDivision}', [LocationController::class, 'getBlocks']);
    Route::get('/api/vcdcs/{block}', [LocationController::class, 'getVcdcs']);


    Route::get('/questions/by-section/{section}', [QuestionAdminController::class, 'getBySection']);
    Route::get('/sections/by-survey/{survey}', [SectionAdminController::class, 'getBySurvey']);
    Route::get('/surveys/{survey}/answers', [SurveyAnswerController::class, 'bySurvey'])->name('surveys.answers');
    Route::get('/survey-answers/{id}/export', [SurveyAnswerController::class, 'exportExcel'])->name('survey-answers.export');
    Route::get('/questions/existing-by-section/{section}', [QuestionAdminController::class, 'existingBySection']);

    Route::resource('survey-answers', SurveyAnswerController::class)->only(['index', 'show']);
    Route::get('survey-answers-with-user', [SurveyAnswerController::class, 'indexWithUser'])->name('surveys.answersWithUser');
    Route::get('users-list-by-survey/{id}', [SurveyAnswerController::class, 'userListBySurvey'])->name('surveys.userListBySurvey');
    Route::get('survey-reports', [SurveyAnswerController::class, 'surveyAnswerReport'])->name('surveys.surveyAnswerReport');

    Route::get('section-wise-report/{id}', [SurveyAnswerController::class, 'sectionWiseReport'])->name('survey.sectionReport');


    Route::get('users/{user_id}', [UserController::class, 'show'])->name('admin.users.show');

    Route::get('user-locations', [UserLocationController::class, 'index'])->name('admin.user-locations.map');
    Route::get('user-locations/ajax', [UserLocationController::class, 'ajax'])->name('admin.user-locations.ajax');

});

Route::get('/', [CallLetterController::class, 'showCallLetterPage'])->name('showCallLetterPage');
//Route::get('/call-letter', [CallLetterController::class, 'showCallLetterPage'])->name('showCallLetterPage');
Route::post('/validate-user', [CallLetterController::class, 'validate'])->name('validate');
Route::post('/validate-user-json', [CallLetterController::class, 'validateJson'])->name('validateJson');
Route::post('/call-letter-pdf', [CallLetterController::class, 'printPdf'])->name('printPdf');

