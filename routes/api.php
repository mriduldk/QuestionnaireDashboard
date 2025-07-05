<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SurveyApiController;
use App\Http\Controllers\SurveyAnswerController;
use App\Http\Controllers\QuestionAnswerController;
use App\Http\Controllers\CurrentLocationController;
use App\Http\Controllers\LocationHistoryController;


Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('checkUserPhoneNumber', 'checkUserPhoneNumber');
    Route::post('otpVerify', 'otpVerify');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});


Route::get('/surveys/{survey}', [SurveyApiController::class, 'show']);

Route::post('/survey-answer/upsert', [SurveyAnswerController::class, 'upsert']);

Route::post('/question-answer/upsert', [QuestionAnswerController::class, 'upsert']);

Route::post('/current-location/upsert', [CurrentLocationController::class, 'upsert']);

Route::post('/location-history/upsert', [LocationHistoryController::class, 'upsert']);

