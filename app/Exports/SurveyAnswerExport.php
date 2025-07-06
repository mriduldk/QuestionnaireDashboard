<?php

namespace App\Exports;

use App\Models\SurveyAnswer;
use App\Models\QuestionAnswer;
use App\Models\Survey;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SurveyAnswerExport implements FromArray, WithHeadings
{
    protected $surveyAnswer;

    public function __construct(SurveyAnswer $surveyAnswer)
    {
        $this->surveyAnswer = $surveyAnswer;
    }

    public function array(): array
    {
        $answers = QuestionAnswer::where('survey_answer_id', $this->surveyAnswer->survey_answer_id)
            ->get()
            ->keyBy('question_id');

        $survey = Survey::with(['sections.questions.subQuestions'])->find($this->surveyAnswer->survey_id);

        $data = [];

        // Add respondent metadata row
        $data[] = [
            'Survey Title' => $survey->title,
            'Name' => $this->surveyAnswer->name,
            'Phone' => $this->surveyAnswer->phone_number,
            'Age' => $this->surveyAnswer->age,
            'Gender' => $this->surveyAnswer->gender,
            'District' => $this->surveyAnswer->district,
            'Block' => $this->surveyAnswer->block,
            'Village' => $this->surveyAnswer->village,
            'Status' => $this->surveyAnswer->status,
        ];

        // Blank row between metadata and answers
        $data[] = [];

        // Section and Question answers
        foreach ($survey->sections as $section) {
            $data[] = ['Section: ' . $section->title];

            foreach ($section->questions as $question) {
                $data[] = [
                    'Question' => $question->question_text,
                    'Answer' => $answers[$question->id]->answer_text ?? '-',
                ];

                foreach ($question->subQuestions as $sub) {
                    $data[] = [
                        'Question' => '↳ ' . $sub->question_text,
                        'Answer' => $answers[$sub->id]->answer_text ?? '-',
                    ];
                }
            }

            $data[] = []; // Spacer row
        }

        return $data;
    }

    public function headings(): array
    {
        return ['Question', 'Answer'];
    }
}

