<?php

namespace App\Http\Controllers;

use App\Exports\SurveyAnswerExport;
use App\Models\Survey;
use Illuminate\Http\Request;
use App\Models\SurveyAnswer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Helpers\ApiResponse;
use Maatwebsite\Excel\Facades\Excel;

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
    public function index(Request $request)
    {
        /*$surveyAnswers = SurveyAnswer::latest()->get();
        return view('admin.survey_answers.index', compact('surveyAnswers'));*/

        $surveys = Survey::withCount('surveyAnswers')->get();
        return view('admin.survey_answers.index', compact('surveys'));
    }

    public function show($id)
    {
        $surveyAnswer = SurveyAnswer::with('user', 'survey')->findOrFail($id);

        $questionAnswers = \App\Models\QuestionAnswer::where('survey_answer_id', $surveyAnswer->survey_answer_id)
            ->get()
            ->keyBy('question_id');

        $survey = $surveyAnswer->survey()
            ->with(['sections.questions.subQuestions'])
            ->first();

        return view('admin.survey_answers.show', compact('surveyAnswer', 'questionAnswers', 'survey'));
    }


    public function bySurvey(Request $request, Survey $survey)
    {
        $query = SurveyAnswer::where('survey_id', $survey->id);

        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        if ($request->filled('vcdc')) {
            $query->where('vcdc', $request->vcdc);
        }

        if ($request->filled('subDivision')) {
            $query->where('sub_division', $request->subDivision); // if you have this column
        }

        // Get distinct values for dropdowns
        $districts = SurveyAnswer::where('survey_id', $survey->id)->select('district')->distinct()->pluck('district');
        $vcdcs = SurveyAnswer::where('survey_id', $survey->id)->select('vcdc')->distinct()->pluck('vcdc');
        $subDivisions = SurveyAnswer::where('survey_id', $survey->id)->select('sub_division')->distinct()->pluck('sub_division');


        $answers = $query->get();

        return view('admin.survey_answers.by_survey', compact('survey', 'answers', 'districts', 'vcdcs', 'subDivisions'));
    }

    public function exportExcel($id)
    {
        $surveyAnswer = SurveyAnswer::findOrFail($id);
        $filename = 'survey_answer_' . $surveyAnswer->survey_answer_id . '.xlsx';

        return Excel::download(new SurveyAnswerExport($surveyAnswer), $filename);
    }



}
