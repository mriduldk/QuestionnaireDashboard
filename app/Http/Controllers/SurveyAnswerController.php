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
            return ApiResponse::success(200, 'Survey answer updated', "surveyAnswer", $surveyAnswer);
        } else {
            // Insert
            $validated['survey_answer_id'] = $validated['survey_answer_id'] ?? Str::uuid()->toString();
            $surveyAnswer = SurveyAnswer::create($validated);
            return ApiResponse::success(201, 'Survey answer created', "surveyAnswer", $surveyAnswer);
        }
    }

    // Show list of survey answers
    public function index()
    {
        $surveyAnswers = SurveyAnswer::latest()->get();
        return view('admin.survey_answers.index', compact('surveyAnswers'));
    }

    // Show details of a single survey answer
    /*public function show($id)
    {
        $surveyAnswer = SurveyAnswer::findOrFail($id);
        return view('admin.survey_answers.show', compact('surveyAnswer'));
    }*/

    public function show($id)
    {
        //$surveyAnswer = SurveyAnswer::findOrFail($id);
        $surveyAnswer = SurveyAnswer::with('user')->findOrFail($id);

        // Fetch all related question answers grouped by question_id
        $questionAnswers = \App\Models\QuestionAnswer::where('survey_answer_id', $surveyAnswer->survey_answer_id)
            ->get()
            ->keyBy('question_id');

        // Load all surveys with sections and questions
        $surveys = \App\Models\Survey::with(['sections.questions.subQuestions'])->get();

        return view('admin.survey_answers.show', compact('surveyAnswer', 'questionAnswers', 'surveys'));
    }



}
