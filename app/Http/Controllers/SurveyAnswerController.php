<?php

namespace App\Http\Controllers;

use App\Exports\SurveyAnswerExport;
use App\Models\District;
use App\Models\Survey;
use App\Models\User;
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


    // New API Start -- 12-09-2025

    public function getOnlySurveyAnswerByUserId($userId)
    {
        //$surveyAnswer = SurveyAnswer::with('survey', 'questionAnswers', 'multipleQuestionAnswers')->where('user_id', $userId)->get();

        $surveyAnswer = SurveyAnswer::with('survey')
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
    public function getOnlyQuestionAnswerBySurveyAnswerId($surveyAnswerId)
    {
        $surveyAnswer = SurveyAnswer::with('survey', 'questionAnswers', 'multipleQuestionAnswers')
        ->where('survey_answer_id', $surveyAnswerId)
        ->first(); // 👈 convert models to plain array first

        if ($surveyAnswer) {

            $surveyAnswerCamelCase = $this->toCamelCaseArray($surveyAnswer);

            return ApiResponse::success(200, 'Survey answer updated', "surveyAnswerServer", $surveyAnswerCamelCase);

        } else {
            return ApiResponse::success(204, 'Survey answer updated', "surveyAnswerServer", null);
        }
    }

    // END



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
        $districts = District::orderBy('id', 'asc')->pluck('name', 'id');
        //$query = SurveyAnswer::where('survey_id', $survey->id);
        $answers = SurveyAnswer::where('survey_id', $survey->id)->get();

        if ($request->filled('district')) {

            $districtFilter = $request->district;

            $answers = $answers->filter(function ($ans) use ($districtFilter) {

                if ($ans->form_specs == null){
                    return false;
                }
                // Ensure $data is always an array
                $data = is_array($ans->form_specs)
                    ? $ans->form_specs
                    : json_decode($ans->form_specs, true);


                if (!$data) {
                    return false;
                }

                foreach ($data as $section) {
                    foreach ($section['components'] as $comp) {
                        if (($comp['id'] ?? null) === 'district' && ($comp['answer'] ?? null) == $districtFilter) {
                            return true;
                        }
                    }
                }
                return false;
            });

        }

        //$answers = $query->get();

        return view('admin.survey_answers.by_survey', compact(
            'survey',
            'answers',
            'districts',
        ));
    }

    public function exportExcel($id)
    {
        $surveyAnswer = SurveyAnswer::findOrFail($id);
        $filename = 'survey_answer_' . $surveyAnswer->survey_answer_id . '.xlsx';

        return Excel::download(new SurveyAnswerExport($surveyAnswer), $filename);
    }


    public function indexWithUser(Request $request)
    {
        /*$surveyAnswers = SurveyAnswer::latest()->get();
        return view('admin.survey_answers.index', compact('surveyAnswers'));*/

        $surveys = Survey::withCount(['surveyAnswers', 'users'])->get();
        return view('admin.survey_answers.index_with_user', compact('surveys'));
    }

    public function userListBySurvey($id, Request $request)
    {
        //$users = User::where('is_delete', false)->where('survey_id', $id)->with('survey')->withCount('surveyAnswers')->get();
        //$filter = $request->get('performance'); // zero, low, medium, high

        $districts = District::orderBy('id', 'asc')->pluck('name', 'id'); // assuming you have District model


        $users = User::with(['districtInfo', 'survey'])
            ->withCount('surveyAnswers')
            ->where('survey_id', $id)
            ->where('is_delete', false)
            ->get();

        // Calculate performance for each user
        foreach ($users as $u) {
            if ($u->survey_id == 17) {
                $startDate = \Carbon\Carbon::create(2025, 8, 20);
            } else if ($u->survey_id == 21) {
                $startDate = \Carbon\Carbon::create(2025, 8, 26);
            } else if ($u->survey_id == 22) {
                $startDate = \Carbon\Carbon::create(2025, 9, 1);
            } else {
                $startDate = \Carbon\Carbon::create(2025, 9, 1);
            }

            $today = \Carbon\Carbon::today();
            $totalDays = $startDate->diffInDays($today) + 1;
            $expectedAnswers = $totalDays * 5;

            $u->performance = $expectedAnswers > 0
                ? round(($u->survey_answers_count / $expectedAnswers) * 100, 2)
                : 0;
        }

        // Apply filter
        $performanceFilter = $request->performance;
        $districtFilter    = $request->district;


        if ($performanceFilter) {
            $users = $users->filter(function ($u) use ($performanceFilter) {
                if ($performanceFilter === 'zero') {
                    return $u->survey_answers_count == 0;
                } elseif ($performanceFilter === 'low') {
                    return $u->performance < 50;
                } elseif ($performanceFilter === 'medium') {
                    return $u->performance >= 50 && $u->performance < 80;
                } elseif ($performanceFilter === 'high') {
                    return $u->performance >= 80;
                }
                return true;
            });
        }

        // District filter
        if ($districtFilter) {
            $users = $users->filter(function ($u) use ($districtFilter) {
                return $u->district == $districtFilter;
            });
        }



        // $surveyNames = Survey::pluck('title', 'id');

        // // Survey-wise trend
        // $trend = SurveyAnswer::selectRaw("survey_id, DATE(created_at) as date, COUNT(*) as count")
        //     ->where('survey_id', $id)
        //     ->groupBy('survey_id', 'date')
        //     ->orderBy('survey_id')
        //     ->orderBy('date')
        //     ->get();

        // // Format survey-wise trend
        // $trendBySurvey = $trend->groupBy('survey_id')->map(function ($rows, $surveyId) use ($surveyNames) {
        //     $surveyName = $surveyNames[$surveyId] ?? "Survey {$surveyId}";
        //     return [
        //         'name'   => $surveyName,
        //         'labels' => $rows->pluck('date')->toArray(),
        //         'data'   => $rows->pluck('count')->toArray(),
        //     ];
        // });


        // District counts per survey
        // $answers = DB::table('survey_answers')
        //     ->where('survey_id', $id)
        //     ->get();

        // $districtCounts = collect();
        // foreach ($answers as $ans) {
        //     $data = json_decode($ans->form_specs, true);
        //     if (!$data) continue;

        //     foreach ($data as $section) {
        //         foreach ($section['components'] as $comp) {
        //             if (($comp['id'] ?? null) === 'district') {
        //                 $district = $comp['answer'] ?? null;
        //                 if ($district) {
        //                     $districtCounts[$district] = ($districtCounts[$district] ?? 0) + 1;
        //                 }
        //             }
        //         }
        //     }
        // }
        // $districtChartData = [
        //     'name'   => $surveyNames[$id] ?? "Survey {$id}",
        //     'labels' => $districtCounts->keys()->toArray(),   // District names
        //     'data'   => $districtCounts->values()->toArray(), // Counts
        // ];


        // $answers2 = DB::table('survey_answers')
        //     ->where('survey_id', $id)
        //     ->select('form_specs', DB::raw('DATE(created_at) as date'))
        //     ->get();

        // $districtTrend = [];

        // foreach ($answers2 as $ans) {
        //     $data = json_decode($ans->form_specs, true);
        //     if (!$data) continue;

        //     $district = null;
        //     foreach ($data as $section) {
        //         foreach ($section['components'] as $comp) {
        //             if (($comp['id'] ?? null) === 'district') {
        //                 $district = $comp['answer'] ?? null;
        //                 break 2; // stop both loops once found
        //             }
        //         }
        //     }

        //     if ($district) {
        //         $districtTrend[$district][$ans->date] = ($districtTrend[$district][$ans->date] ?? 0) + 1;
        //     }
        // }

        // // Format for chart (district → {name, labels, data})
        // $districtTrendChart = [];
        // foreach ($districtTrend as $district => $rows) {
        //     ksort($rows); // sort by date
        //     $districtTrendChart[] = [
        //         'name'   => $district,
        //         'labels' => array_keys($rows),
        //         'data'   => array_values($rows),
        //     ];
        // }

        return view('admin.survey_answers.users_by_survey', compact(
            'id',
            'users',
            'districts'
        ));
    }

    public function surveyAnswerReport()
    {
        $surveyNames = \App\Models\Survey::pluck('title', 'id');

        // Survey-wise trend
        $trend = SurveyAnswer::selectRaw("survey_id, DATE(created_at) as date, COUNT(*) as count")
            ->groupBy('survey_id', 'date')
            ->orderBy('survey_id')
            ->orderBy('date')
            ->get();

        // Format survey-wise trend
        $trendBySurvey = $trend->groupBy('survey_id')->map(function ($rows, $surveyId) use ($surveyNames) {
            $surveyName = $surveyNames[$surveyId] ?? "Survey {$surveyId}";
            return [
                'name'   => $surveyName,
                'labels' => $rows->pluck('date')->toArray(),
                'data'   => $rows->pluck('count')->toArray(),
            ];
        });


        // District counts per survey
        $districtCounts = DB::table(DB::raw("(
                SELECT survey_id, JSON_UNQUOTE(JSON_EXTRACT(form_specs, '$[0].components[0].answer')) as district
                FROM survey_answers
            ) as t"))
            ->select('survey_id', 'district', DB::raw('COUNT(*) as total'))
            ->groupBy('survey_id', 'district')
            ->get()
            ->groupBy('survey_id');

        // Format for chart
        $districtChartData = $districtCounts->map(function ($rows, $surveyId) use ($surveyNames) {
            return [
                'name'   => $surveyNames[$surveyId] ?? "Survey {$surveyId}",
                'labels' => $rows->pluck('district')->toArray(),
                'data'   => $rows->pluck('total')->toArray(),
            ];
        });

        //dd($districtChartData);

        return view('admin.survey_answers.survey-answer-report', compact(
            'trendBySurvey',
            'districtChartData'
        ));

    }


    public function sectionWiseReport($surveyId)
    {
        $survey = Survey::findOrFail($surveyId);

        // Paginate sections with their main questions
        $sections = $survey->sections()
            ->with(['questions' => function ($q) {
                $q->whereNull('parent_id'); // only main questions
            }])
            ->paginate(1); // show 1 section per page (adjust as needed)

        // Pre-fetch aggregated counts for this survey
        $counts = \App\Models\QuestionAnswer::select(
            'question_id',
            'answer_text',
            \DB::raw('COUNT(*) as total')
        )
            ->where('survey_id', $surveyId)
            ->groupBy('question_id', 'answer_text')
            ->get()
            ->groupBy('question_id');

        $chartData = [];

        foreach ($sections as $section) {
            $sectionData = [
                'title' => $section->title,
                'questions' => []
            ];

            foreach ($section->questions as $question) {
                $questionCounts = $counts->get($question->id, collect());

                $labels = $questionCounts->pluck('answer_text')->toArray();
                $data   = $questionCounts->pluck('total')->toArray();

                $sectionData['questions'][] = [
                    'text'   => $question->question_text,
                    'labels' => $labels,
                    'data'   => $data,
                ];
            }

            $chartData[] = $sectionData;
        }

        return view('admin.survey_answers.section_wise_report', compact('survey', 'sections', 'chartData'));
    }



}
