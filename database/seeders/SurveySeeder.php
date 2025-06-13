<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Survey;
use App\Models\Section;
use App\Models\Question;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run()
    {
        $survey = Survey::create([
            'title' => 'Eri Sericulture Survey',
            'description' => 'Study on status of sericulture in the BTR',
            'status' => true,
        ]);

        $section1 = $survey->sections()->create([
            'title' => 'General Information',
            'order' => 1,
        ]);

        $section1->questions()->createMany([
            [
                'question_text' => 'What is your district?',
                'type' => 'text',
                'is_required' => true,
            ],
            [
                'question_text' => 'Are you involved in sericulture?',
                'type' => 'radio',
                'is_required' => true,
                'metadata' => json_encode(['options' => ['Yes', 'No']]),
            ]
        ]);

        $section2 = $survey->sections()->create([
            'title' => 'Rearing and Plantation',
            'order' => 2,
        ]);

        $section2->questions()->create([
            'question_text' => 'Do you have your own plantation?',
            'type' => 'radio',
            'is_required' => false,
            'metadata' => json_encode(['options' => ['Yes', 'No']])
        ]);
    }
    
}
