<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\AnswerController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/surveys', [SurveyController::class, 'index']);
Route::get('/surveys/{id}', [SurveyController::class, 'show']);
Route::post('/answers', [AnswerController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    
});

