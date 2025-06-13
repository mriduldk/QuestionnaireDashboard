<?php

use App\Http\Controllers\Api\SurveyApiController;


Route::get('/surveys/{survey}', [SurveyApiController::class, 'show']);
