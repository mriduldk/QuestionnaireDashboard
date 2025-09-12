<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\MultipleQuestionAnswerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SurveyApiController;
use App\Http\Controllers\SurveyAnswerController;
use App\Http\Controllers\QuestionAnswerController;
use App\Http\Controllers\CurrentLocationController;
use App\Http\Controllers\LocationHistoryController;
use App\Http\Controllers\SurveyAnswerImageController;


Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('checkUserPhoneNumber', 'checkUserPhoneNumber');
    Route::post('otpVerify', 'otpVerify');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});


Route::get('/surveys/{survey}', [SurveyApiController::class, 'show']);
Route::get('/surveys/{surveyId}/{userId}', [SurveyApiController::class, 'showWithUserId']);

Route::post('/survey-answer/upsert', [SurveyAnswerController::class, 'upsert']);
Route::get('/survey-answer/getByUserId/{userId}', [SurveyAnswerController::class, 'getByUserId']);
Route::post('/survey-answer/bulk-sync', [SurveyAnswerController::class, 'bulkSync']);

Route::post('/question-answer/upsert', [QuestionAnswerController::class, 'upsert']);

Route::post('/current-location/upsert', [CurrentLocationController::class, 'upsert']);

Route::post('/location-history/upsert', [LocationHistoryController::class, 'upsert']);

Route::post('/multiple-question-answer/upsert', [MultipleQuestionAnswerController::class, 'upsert']);

Route::get('/surveys/{survey}/json', [SurveyApiController::class, 'showJson']);

Route::post('/survey-answer-images', [SurveyAnswerImageController::class, 'store']);

Route::post('/store-profile-image', [AuthController::class, 'storeProfileImage']);
Route::post('/update-profile-info', [AuthController::class, 'updateSubDivisionAndBlock']);
Route::post('/getByUserId', [AuthController::class, 'getByUserId']);
Route::post('/updateUserLanguage', [AuthController::class, 'updateUserLanguage']);

//New
Route::get('/survey-answer/getOnlySurveyAnswerByUserId/{userId}', [SurveyAnswerController::class, 'getOnlySurveyAnswerByUserId']);
Route::get('/survey-answer/getOnlyQuestionAnswerBySurveyAnswerId/{surveyAnswerId}', [SurveyAnswerController::class, 'getOnlyQuestionAnswerBySurveyAnswerId']);


Route::post('/leave/apply-leave', [LeaveController::class, 'applyLeaveStore']);
Route::get('/leave/view-leave/{id}', [LeaveController::class, 'viewLeave']);
Route::post('/leave/my-leaves', [LeaveController::class, 'myLeaves']);




use App\Http\Controllers\UserDataController;

Route::post('/user-data/store', [UserDataController::class, 'store']);
Route::get('/user-data/count', [UserDataController::class, 'count']);
Route::post('/user-data/store-message', [UserDataController::class, 'storeMessage']);
