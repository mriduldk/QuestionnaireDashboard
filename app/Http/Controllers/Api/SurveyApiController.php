<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Http\Request;

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
            'sections' => $survey->sections->map(function ($section) {
                $questions = $section->questions->whereNull('parent_id')->map(function ($question) use ($section) {
                    return $this->formatQuestion($question, $section->questions);
                });

                return [
                    'id' => $section->id,
                    'title' => $section->title,
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
        return [
            'id' => $question->id,
            'text' => $question->question_text,
            'type' => $question->type,
            'is_required' => $question->is_required,
            'metadata' => $question->metadata ?? [],
            'conditional_logic' => $question->conditional_logic ?? null,
            'sub_questions' => $allQuestions
                ->where('parent_id', $question->id)
                ->map(fn ($sub) => $this->formatQuestion($sub, $allQuestions))
                ->values()
        ];
    }
}
