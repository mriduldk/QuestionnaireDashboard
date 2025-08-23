<?php

namespace App\Http\Controllers;

use App\Exports\SurveyAnswerExport;
use App\Models\Survey;
use Illuminate\Http\Request;
use App\Models\SurveyAnswer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Helpers\ApiResponse;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class SurveyAnswerController extends Controller
{
    public function upsert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'survey_answer_id' => 'required|uuid',
            'survey_id' => 'required',
            'district' => 'nullable|string',
            'sub_division' => 'nullable|string',
            'block' => 'nullable|string',
            'vcdc' => 'nullable|string',
            'village' => 'nullable|string',
            'ward_no' => 'nullable|string',
            'house_no' => 'nullable|string',
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
            'form_specs' => 'nullable|array',
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

    public function getByUserId($userId)
    {
        //$surveyAnswer = SurveyAnswer::with('survey', 'questionAnswers', 'multipleQuestionAnswers')->where('user_id', $userId)->get();

        $surveyAnswer = SurveyAnswer::with('survey', 'questionAnswers', 'multipleQuestionAnswers')
        ->where('user_id', $userId)
        ->get()
        ->toArray(); // 👈 convert models to plain array first

        if ($surveyAnswer) {

            $surveyAnswerCamelCase = $this->toCamelCaseArray($surveyAnswer);

            return ApiResponse::success(200, 'Survey answer updated', "surveyAnswersServer", $surveyAnswerCamelCase);

        } else {
            return ApiResponse::success(204, 'Survey answer updated', "surveyAnswersServer", null);
        }
    }
    private function toCamelCaseArray($data)
    {
        if (is_array($data)) {
            $newArray = [];
            foreach ($data as $key => $value) {
                 // If the current key is "multiple_question_answers", keep as-is
                if ($key === 'multiple_question_answers') {
                    $newArray[$key] = $value; // No camelCase change
                    continue;
                }

                $camelKey = is_string($key)
                    ? lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))))
                    : $key;
                $newArray[$camelKey] = $this->toCamelCaseArray($value);
            }
            return $newArray;
        }
        return $data;
    }

    public function bulkSync(Request $request)
    {
        // The request is already validated by BulkSyncRequest
        $surveysData = $request->surveys;

        // Use a database transaction to ensure data integrity
        DB::beginTransaction();

        try {
            foreach ($surveysData as $surveyData) {
                // 1. Create the main Survey record
                // Use updateOrCreate to handle potential re-submissions gracefully
                $survey = SurveyAnswer::updateOrCreate(
                    ['survey_answer_id' => $surveyData['survey_answer_id']],
                    [
                        'survey_id' => $surveyData['survey_id'],
                        'form_specs'  => $surveyData['form_specs'],
                        'user_id'  => $surveyData['user_id'],
                    ]
                );


                // 2. Create the related QuestionAnswer records
                foreach ($surveyData['questionAnswers'] ?? [] as $questionData) {

                    //dd($questionData);

                    $survey->questionAnswers()->updateOrCreate(
                        ['question_answer_id' => $questionData['questionAnswerId']],
                        [
                            'survey_answer_id' => $questionData['surveyAnswerId'],
                            'question_id' => $questionData['questionId'],
                            'section_id' => $questionData['sectionId'],
                            'survey_id' => $questionData['surveyId'],
                            'type' => $questionData['type'],
                            'answer_text' => $questionData['answerText'] ?? "",
                            'is_answered' => $questionData['isAnswered'],
                            'is_multiple' => $questionData['isMultiple'],
                            //'user_id' => $questionData['user_id']
                        ]
                    );
                }

                // 3. Create the related MultipleQuestionAnswer records
                foreach ($surveyData['multiple_question_answers'] ?? [] as $multiAnswerData) {

                    //dd($multiAnswerData);

                    $survey->multipleQuestionAnswers()->updateOrCreate(
                        ['multiple_question_answer_id' => $multiAnswerData['multiple_question_answer_id']],
                        [
                            'question_answer_id' => $multiAnswerData['question_answer_id'],
                            'survey_answer_id' => $multiAnswerData['survey_answer_id'],
                            'question_id'   => $multiAnswerData['question_id'],
                            'section_id'    => $multiAnswerData['section_id'],
                            'survey_id' => $multiAnswerData['survey_id'],
                            'type'  => $multiAnswerData['type'],
                            'answer_text'   => $multiAnswerData['answer_text'],
                            'is_answered'   => $multiAnswerData['is_answered'],
                            'is_multiple'   => $multiAnswerData['is_multiple'],
                            'sl_no' => $multiAnswerData['sl_no'],

                        ]
                    );
                }
            }

            // If everything was successful, commit the transaction
            DB::commit();

            return ApiResponse::success(200, 'Survey Saved Successfully', "surveyAnswer", null);
            //return response()->json(['message' => 'Data synced successfully'], 200);

        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Bulk sync failed: ' . $e->getMessage());
            //return response()->json(['message' => 'An error occurred during sync.', 'error' => $e->getMessage()], 500);
            return ApiResponse::error('An error occurred during sync. Please try again', $e->getMessage(), 422);
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

        // Multiple answers (Checkbox, Multi-select, etc.)
        $multipleQuestionAnswers = \App\Models\MultipleQuestionAnswer::where('survey_answer_id', $surveyAnswer->survey_answer_id)
        ->get()
        ->groupBy('question_id');

        $survey = $surveyAnswer->survey()
            ->with(['sections.questions.subQuestions'])
            ->first();

        return view('admin.survey_answers.show', compact('surveyAnswer', 'questionAnswers', 'multipleQuestionAnswers', 'survey'));
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
