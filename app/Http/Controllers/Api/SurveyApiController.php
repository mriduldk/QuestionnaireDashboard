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


        $surveyHeaderSections = [];

        if ($surveyId == 17) {
            $surveyHeaderSections = [
                [
                    "id" => 1,
                    "title" => "Demographic Information",
                    "surveyId" => 17,
                    "components" => [
                        ["type" => "Dropdown", "id" => "district", "label" => "District", "options" => ["KOKRAJHAR", "CHIRANG", "BAKSA", "TAMULPUR", "UDALGURI"], "required" => true, 'header' => true, 'holdPreviousValue' => true],
                        ["type" => "Text", "id" => "village", "label" => "Village/Town Name", "hint" => "Enter village/town name", "required" => true, 'header' => true, 'holdPreviousValue' => true],
                        ["type" => "Text", "id" => "wardno", "label" => "Ward No", "hint" => "Enter Ward No", "required" => false, 'header' => true, 'holdPreviousValue' => false],
                        ["type" => "Text", "id" => "houseno", "label" => "House No", "hint" => "Enter House No", "required" => false, 'header' => true, 'holdPreviousValue' => false],
                    ]
                ],
                [
                    "id" => 2,
                    "title" => "Responder's Information",
                    "surveyId" => 17,
                    "components" => [
                        ["type" => "Text", "id" => "name", "label" => "Name of the Responder", "hint" => "Enter Name of the Responder", "required" => true, 'header' => true, 'holdPreviousValue' => false],
                        ["type" => "Number", "id" => "phone", "label" => "Phone / Mobile Number (Optional)", "hint" => "Enter Phone / Mobile Number", "required" => false, 'header' => true, 'holdPreviousValue' => false],
                        ["type" => "Number", "id" => "age", "label" => "Age", "hint" => "Enter Age", "required" => true, "min" => 5, "max" => 100, 'header' => false, 'holdPreviousValue' => false],
                        ["type" => "Text", "id" => "relationshipWithHousehold", "label" => "Relationship with Head of Household", "hint" => "Enter Relationship with Head of Household", "required" => true, 'header' => false, 'holdPreviousValue' => false],
                    ]
                ]
            ];
        } elseif ($surveyId == 21) {
            $surveyHeaderSections = [
                [
                    "id" => 3,
                    "title" => "Demographic Information",
                    "surveyId" => 21,
                    "components" => [
                        ["type" => "Dropdown", "id" => "district", "label" => "District", "options" => ["KOKRAJHAR", "CHIRANG", "BAKSA", "TAMULPUR", "UDALGURI"], "required" => true, 'header' => true, 'holdPreviousValue' => true],
                        ["type" => "Text", "id" => "village", "label" => "Village/Town Name", "hint" => "Enter village/town name", "required" => true, 'header' => true, 'holdPreviousValue' => true],


                        ["type" => "Text", "id" => "name", "label" => "Name of the Participant", "hint" => "Enter Name of the Participant", "required" => true, 'header' => true, 'holdPreviousValue' => false],
                        ["type" => "Radio", "id" => "gender", "label" => "Gender", "options" => ["Male", "Female", "Other"], "required" => true, 'header' => false, 'holdPreviousValue' => false],
                        ["type" => "Radio", "id" => "religion", "label" => "Religion", "options" => ["Hindu", "Muslim", "Christian", "Bathouism", "Sikh", "Other"], "required" => true, 'header' => false, 'holdPreviousValue' => false],
                        // ["type" => "Number", "id" => "age", "label" => "Age", "hint" => "Enter Age", "required" => true, "min" => 5, "max" => 100, 'header' => false, 'holdPreviousValue' => false],
                        ["type" => "Dropdown", "id" => "caste", "label" => "Caste", "options" => ["GENERAL", "OBC / MOBC", "SC", "ST"], "required" => true, 'header' => false, 'holdPreviousValue' => false],
                        ["type" => "Text", "id" => "nameofthecommunity", "label" => "Name of the Community", "hint" => "E.g. Boro Kochari", "required" => true, 'header' => false, 'holdPreviousValue' => false],

                        ["type" => "Dropdown", "id" => "agerange", "label" => "Which category below includes your age?", "options" => ["Under 20", "20-30", "31-40", "41-50", "Over 50"], "required" => true, 'header' => false, 'holdPreviousValue' => false],
                        ["type" => "Dropdown", "id" => "marital_status", "label" => "Marital Status", "options" => ["Married", "Unmarried", "Divorce/Separated", "Widowed"], "required" => true, 'header' => false, 'holdPreviousValue' => false],
                        ["type" => "Dropdown", "id" => "education", "label" => "Education", "options" => ["No formal education", "Primary", "HSLC", "Higher Secondary", "Graduate & Above", "Other"], "required" => true, 'header' => false, 'holdPreviousValue' => false],
                        ["type" => "Dropdown", "id" => "occupation", "label" => "Occupation", "options" => ["Housewife", "Daily wage laborer", "Government/Private Employee", "Self-Employed", "Other"], "required" => true, 'header' => false, 'holdPreviousValue' => false]
                    ]
                ]
            ];
        } elseif ($surveyId == 22) {
            $surveyHeaderSections = [
                [
                    "id" => 4,
                    "title" => "Respondent Information",
                    "surveyId" => 22,
                    "components" => [
                        ["type" => "Dropdown", "id" => "district", "label" => "District", "options" => ["KOKRAJHAR", "CHIRANG", "BAKSA", "TAMULPUR", "UDALGURI"], "required" => true, 'header' => true, 'holdPreviousValue' => true],
                        ["type" => "Text", "id" => "village", "label" => "Village/Town Name", "hint" => "Enter village/town name", "required" => true, 'header' => true, 'holdPreviousValue' => true],

                        ["type" => "Text", "id" => "name", "label" => "Name of the Participant", "hint" => "Enter Name of the Participant", "required" => true, 'header' => true, 'holdPreviousValue' => false],
                        ["type" => "Number", "id" => "age", "label" => "Age", "hint" => "Enter Age", "required" => true, "min" => 5, "max" => 100, 'header' => true, 'holdPreviousValue' => false],
                        ["type" => "Radio", "id" => "gender", "label" => "Gender", "options" => ["Male", "Female", "Other"], "required" => true, 'header' => false, 'holdPreviousValue' => false],
                        ["type" => "Radio", "id" => "religion", "label" => "Religion", "options" => ["Hindu", "Muslim", "Christian", "Bathouism", "Sikh", "Other"], "required" => true, 'header' => false, 'holdPreviousValue' => false],
                        ["type" => "Dropdown", "id" => "caste", "label" => "Caste", "options" => ["GENERAL", "OBC / MOBC", "SC", "ST"], "required" => true, 'header' => false, 'holdPreviousValue' => false],
                        ["type" => "Dropdown", "id" => "marital_status", "label" => "Marital Status", "options" => ["Married", "Unmarried", "Divorce/Separated", "Widowed"], "required" => true, 'header' => false, 'holdPreviousValue' => false],
                        ["type" => "Dropdown", "id" => "education", "label" => "Education", "options" => ["No formal education", "Primary", "HSLC", "Higher Secondary", "Graduate & Above", "Other"], "required" => true, 'header' => false, 'holdPreviousValue' => false],
                        ["type" => "Text", "id" => "occupation", "label" => "Occupation", "hint" => "Enter Occupation", "required" => true, 'header' => true, 'holdPreviousValue' => false],
                    ]
                ]
            ];
        }

        return response()->json([
            'status' => 200,
            'message' => "Survey Fetched Successfully",
            'survey' => $data,
            'surveyHeaderSections' => $surveyHeaderSections
        ], 200);

        // return response()->json([
        //     'status' => 200,
        //     'message' => "Survey Fetched Successfully",
        //     'survey' => $data,
        //     'surveyHeaderSections' =>
        //         [
        //             [
        //                 "id" => 1,
        //                 "title" => "Demographic Information",
        //                 "surveyId" => 17,
        //                 "components" => [
        //                     ["type" => "Dropdown", "id" => "district", "label" => "District", "options" => ["KOKRAJHAR", "CHIRANG", "BAKSA", "TAMULPUR", "UDALGURI"], "required" => true, 'header' => true, 'holdPreviousValue' => true],
        //                     /*["type" => "AutoComplete", "id" => "vcdc", "label" => "VCDC", "options" => ["AFLAGAON","ANTHAIBIL","BARAGARI","BINNACHARA","BONGSHIGAON","BORSHIJHORA","CHITHILA","DALOWABARI","DHAULIGURI","DUMARIGURI","GUWABARI","JAGDAI","KARAITARI","KOLABARI","MAGURMARI","PACHAGARH","PRATAPKHATA","RAMFALBIL","SARALPARA","SERFANGURI","SHAKTIASHRAM","SIALMARI","SUKANJHORA","DOTMA DEV"], "required" => true, 'header' => true, 'holdPreviousValue' => true],*/
        //                     /*["type" => "Text", "id" => "district", "label" => "District", "hint" => "Enter District", "required" => true, 'header' => true, 'holdPreviousValue' => true],
        //                     ["type" => "AutoComplete", "id" => "vcdc", "label" => "VCDC", "hint" => "Enter VCDC", "required" => true, 'header' => true, 'holdPreviousValue' => true],*/
        //                     ["type" => "Text", "id" => "village", "label" => "Village/Town Name", "hint" => "Enter village/town name", "required" => true, 'header' => true, 'holdPreviousValue' => true],
        //                     ["type" => "Text", "id" => "wardno", "label" => "Ward No", "hint" => "Enter Ward No", "required" => false, 'header' => true, 'holdPreviousValue' => false],
        //                     ["type" => "Text", "id" => "houseno", "label" => "House No", "hint" => "Enter House No", "required" => false, 'header' => true, 'holdPreviousValue' => false],
        //                     /*["type" => "Number", "id" => "age", "label" => "Age", "hint" => "18+", "required" => true, "min" => 18, "max" => 100],
        //                     ["type" => "Radio", "id" => "gender", "label" => "Gender", "options" => ["Male", "Female", "Other"], "required" => true],
        //                     ["type" => "Checkbox", "id" => "hobbies", "label" => "Hobbies", "options" => ["Sports", "Music", "Reading"]],
        //                     ["type" => "Dropdown", "id" => "country", "label" => "Country", "options" => ["India", "USA", "UK"], "required" => true],
        //                     ["type" => "Date", "id" => "dob", "label" => "Date of Birth"],
        //                     ["type" => "Text", "id" => "pan", "label" => "PAN", "hint" => "ABCDE1234F", "regex" => "^[A-Z]{5}[0-9]{4}[A-Z]$"],
        //                     ["type" => "Button", "id" => "submit", "label" => "Submit"]*/
        //                 ]
        //             ],
        //             [
        //                 "id" => 2,
        //                 "title" => "Responder's Information",
        //                 "surveyId" => 17,
        //                 "components" => [
        //                     ["type" => "Text", "id" => "name", "label" => "Name of the Responder", "hint" => "Enter Name of the Responder", "required" => true, 'header' => true, 'holdPreviousValue' => false],
        //                     ["type" => "Number", "id" => "phone", "label" => "Phone / Mobile Number (Optional)", "hint" => "Enter Phone / Mobile Number", "required" => false, 'header' => true, 'holdPreviousValue' => false],
        //                     ["type" => "Number", "id" => "age", "label" => "Age", "hint" => "Enter Age", "required" => true, "min" => 5, "max" => 100, 'header' => false, 'holdPreviousValue' => false],
        //                     ["type" => "Text", "id" => "relationshipWithHousehold", "label" => "Relationship with Head of Household", "hint" => "Enter Relationship with Head of Household", "required" => true, 'header' => false, 'holdPreviousValue' => false],
        //                     /*["type" => "Dropdown", "id" => "gender", "label" => "Gender", "options" => ["MALE", "FEMALE", "OTHER"], "required" => true, 'header' => false, 'holdPreviousValue' => false],
        //                     ["type" => "Dropdown", "id" => "caste", "label" => "Caste", "options" => ["GENERAL", "OBC / MOBC", "SC", "ST"], "required" => true, 'header' => false, 'holdPreviousValue' => false]*/
        //                 ]
        //             ]
        //         ]

        // ], 200);

        //return ApiResponse::success(200, "Survey Fetched Successfully", "survey", $data);
    }

}
