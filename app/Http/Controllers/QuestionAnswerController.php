<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionAnswer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class QuestionAnswerController extends Controller
{
    public function upsert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_answer_id' => 'required|uuid',
            'survey_answer_id' => 'required|uuid',
            'question_id' => 'required|integer',
            'section_id' => 'required|integer',
            'survey_id' => 'required|integer',
            'type' => 'required|string',
            'answer_text' => 'nullable|string',
            'is_answered' => 'nullable|boolean',
            'user_id' => 'required|uuid'
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', $validator->errors(), 422);
        }

        $validated = $validator->validated();

        // Check if question answer already exists
        $questionAnswer = QuestionAnswer::find($validated['question_answer_id']);

        if ($questionAnswer) {
            // Update
            $questionAnswer->fill($validated);
            $questionAnswer->save();

            return ApiResponse::success($questionAnswer, 'Question answer updated');

        } else {
            // Insert
            $questionAnswer = QuestionAnswer::create($validated);

            return ApiResponse::success($questionAnswer, 'Question answer created');
        }
    }
}
