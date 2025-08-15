<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Survey;

class SurveyApiController extends Controller
{
    public function show(Survey $survey)
    {
        //dd($survey);
        $survey->load(['sections.questions' => function ($query) {
            $query->orderBy('id');
        }]);

        $data = [
            'id' => $survey->id,
            'title' => $survey->title,
            'description' => $survey->description,
            'status' => $survey->status,
            //'created_at' => $survey->created_at->format('Y-m-d H:i:s'),
            //'updated_at' => $survey->updated_at->format('Y-m-d H:i:s'),
            'sections' => $survey->sections->map(function ($section) {
                $questions = $section->questions->whereNull('parent_id')->map(function ($question) use ($section) {
                    return $this->formatQuestion($question, $section->questions);
                });

                return [
                    'id' => $section->id,
                    'title' => $section->title,
                    'survey_id' => $section->survey_id,
                    'order' => $section->order,
                    'required' => $section->required,
                    //'created_at' => $section->created_at->format('Y-m-d H:i:s'),
                    //'updated_at' => $section->updated_at->format('Y-m-d H:i:s'),
                    'questions' => $questions->values(),
                ];
            }),
        ];


        return ApiResponse::success(200, "Survey Fetched Successfully", "survey", $data);
        //return response()->json($data);
    }

    public function showJson(Survey $survey)
    {
        $survey->load([
            'sections.questions.subQuestions', // loads nested questions
        ]);

        return response()->json($survey);
    }

    private function formatQuestion($question, $allQuestions)
    {
        $formatted = [
            'id' => $question->id,
            'survey_id' => $question->survey_id ?? $question->section->survey_id, // fallback if not directly available
            'section_id' => $question->section_id,
            'parent_id' => $question->parent_id,
            'question_text' => $question->question_text,
            'type' => $question->type,
            'is_required' => (bool)$question->is_required,
            'is_multiple' => (bool)$question->is_multiple,
            'metadata' => $question->metadata ?? [],
            'conditional_logic' => $question->conditional_logic,
            'repeating' => $question->repeating,
            'header' => $question->header,
            //'created_at' => $question->created_at->format('Y-m-d H:i:s'),
            //'updated_at' => $question->updated_at->format('Y-m-d H:i:s'),
            'sub_questions' => $allQuestions
                ->where('parent_id', $question->id)
                ->map(fn($q) => $this->formatQuestion($q, $allQuestions))
                ->values(),
        ];

        return $formatted;
    }


    public function showWithUserId(int $surveyId, string $userId)
    {
        $survey = Survey::with([
            'sections.questions' => function ($query) {
                $query->orderBy('id');
            }
        ])->find($surveyId);


        if (empty($survey)) {
            return ApiResponse::error(404, "Survey not found");
        }

        $data = [
            'id' => $survey->id,
            'title' => $survey->title,
            'description' => $survey->description,
            'status' => $survey->status,
            //'created_at' => $survey->created_at->format('Y-m-d H:i:s'),
            //'updated_at' => $survey->updated_at->format('Y-m-d H:i:s'),
            'sections' => $survey->sections->map(function ($section) {
                $questions = $section->questions->whereNull('parent_id')->map(function ($question) use ($section) {
                    return $this->formatQuestion($question, $section->questions);
                });

                return [
                    'id' => $section->id,
                    'title' => $section->title,
                    'survey_id' => $section->survey_id,
                    'order' => $section->order,
                    'required' => $section->required,
                    //'created_at' => $section->created_at->format('Y-m-d H:i:s'),
                    //'updated_at' => $section->updated_at->format('Y-m-d H:i:s'),
                    'questions' => $questions->values(),
                ];
            }),
        ];


        return response()->json([
            'status' => 200,
            'message' => "Survey Fetched Successfully",
            'survey' => $data,
            'surveyHeaderSections' =>
                [
                    [
                        "id" => 1,
                        "title" => "Customer Intake",
                        "surveyId" => 17,
                        "components" => [
                            ["type" => "Text", "id" => "fullName", "label" => "Full name", "hint" => "Enter your name", "required" => true],
                            ["type" => "Number", "id" => "age", "label" => "Age", "hint" => "18+", "required" => true, "min" => 18, "max" => 100],
                            ["type" => "Radio", "id" => "gender", "label" => "Gender", "options" => ["Male", "Female", "Other"], "required" => true],
                            ["type" => "Checkbox", "id" => "hobbies", "label" => "Hobbies", "options" => ["Sports", "Music", "Reading"]],
                            ["type" => "Dropdown", "id" => "country", "label" => "Country", "options" => ["India", "USA", "UK"], "required" => true],
                            ["type" => "Date", "id" => "dob", "label" => "Date of Birth"],
                            ["type" => "Text", "id" => "pan", "label" => "PAN", "hint" => "ABCDE1234F", "regex" => "^[A-Z]{5}[0-9]{4}[A-Z]$"],
                            ["type" => "Button", "id" => "submit", "label" => "Submit"]
                        ]
                    ],
                    [
                        "id" => 2,
                        "title" => "Customer Feedback",
                        "surveyId" => 17,
                        "components" => [
                            ["type" => "Text", "id" => "feedback", "label" => "Feedback", "hint" => "Enter your feedback", "required" => true],
                            ["type" => "Radio", "id" => "rating", "label" => "Rating", "options" => ["1", "2", "3", "4", "5"], "required" => true]
                        ]
                    ]
                ]

        ], 200);

        //return ApiResponse::success(200, "Survey Fetched Successfully", "survey", $data);
    }

}
