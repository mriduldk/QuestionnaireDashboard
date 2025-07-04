<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SurveyAnswer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Helpers\ApiResponse;

class SurveyAnswerController extends Controller
{
    public function upsert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'survey_answer_id' => 'required|uuid',
            'district' => 'nullable|string',
            'sub_division' => 'nullable|string',
            'block' => 'nullable|string',
            'vcdc' => 'nullable|string',
            'village' => 'nullable|string',
            'name' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'age' => 'nullable|string',
            'gender' => 'nullable|string',
            'voter_id' => 'nullable|string',
            'caste' => 'nullable|string',
            'house_hold_member' => 'nullable|array',
            'house_hold_member_other' => 'nullable|string',
            'household_livelihood_activities' => 'nullable|array',
            'household_livelihood_activity_other' => 'nullable|string',
            'average_annual_income' => 'nullable|string',
            'user_id' => 'required|string',
            'status' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', $validator->errors(), 422);
        }

        $validated = $validator->validated();

        // Step 3: Find the existing record
        $surveyAnswer = SurveyAnswer::find($validated['survey_answer_id']);

        if ($surveyAnswer) {
            // Update
            $surveyAnswer->fill($validated);
            $surveyAnswer->save();
            return ApiResponse::success($surveyAnswer, 'Survey answer updated');
        } else {
            // Insert
            $validated['survey_answer_id'] = $validated['survey_answer_id'] ?? Str::uuid()->toString();
            $surveyAnswer = SurveyAnswer::create($validated);
            return ApiResponse::success($surveyAnswer, 'Survey answer created', 201);
        }
    }


}
