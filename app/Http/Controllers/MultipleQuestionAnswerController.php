<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MultipleQuestionAnswer;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;

class MultipleQuestionAnswerController extends Controller
{

    public function upsert(Request $request)
    {
        $request->merge([
            'is_answered' => filter_var($request->input('is_answered'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            'is_multiple' => filter_var($request->input('is_multiple'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
        ]);

        $validator = Validator::make($request->all(), [
            'multiple_question_answer_id' => 'required|uuid',
            'question_answer_id' => 'required|uuid',
            'survey_answer_id' => 'required|uuid',
            'question_id' => 'required|integer',
            'section_id' => 'required|integer',
            'survey_id' => 'required|integer',
            'type' => 'required|string',
            'answer_text' => 'nullable|string',
            'is_answered' => 'nullable|boolean',
            'is_multiple' => 'nullable|boolean',
            'sl_no' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', $validator->errors(), 422);
        }

        $validated = $validator->validated();

        $multipleQuestionAnswer = MultipleQuestionAnswer::find($validated['multiple_question_answer_id']);

        if ($multipleQuestionAnswer) {
            // Update
            $multipleQuestionAnswer->fill($validated);
            $multipleQuestionAnswer->save();

            return ApiResponse::success(200, 'Multiple question answer updated', "multipleQuestionAnswer", $multipleQuestionAnswer);
        } else {
            // Create
            $multipleQuestionAnswer = MultipleQuestionAnswer::create($validated);

            return ApiResponse::success(200, 'Multiple question answer created', "multipleQuestionAnswer", $multipleQuestionAnswer);
        }
    }
}
