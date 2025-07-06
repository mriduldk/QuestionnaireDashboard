<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionAnswer;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class SurveyAdminController extends Controller
{
    public function index() {
        $surveys = Survey::latest()->get();
        return view('admin.surveys.index', compact('surveys'));
    }

    public function create() {
        return view('admin.surveys.create');
    }

    public function store(Request $request) {
        $survey = Survey::create($request->only(['title', 'description', 'status']));
        return redirect()->route('surveys.index', $survey);
    }

    public function edit(Survey $survey)
    {
        return view('admin.surveys.edit', compact('survey'));
    }

    public function update(Request $request, Survey $survey)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $survey->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->has('status'), // true if checkbox is checked
        ]);

        return redirect()->route('surveys.index')->with('success', 'Survey updated successfully.');
    }

    public function show(Survey $survey) {
        $survey->load('sections.questions');
        return view('admin.surveys.show', compact('survey'));
    }

    public function destroy(Survey $survey)
    {
        // 1. Check if any survey answers exist
        $hasSurveyAnswers = SurveyAnswer::where('survey_id', $survey->id)->exists();

        if ($hasSurveyAnswers) {
            return redirect()->route('surveys.index')
                ->with('error', 'Cannot delete this survey because answers exist.');
        }

        // 2. Get all related question IDs from its sections
        $questionIds = $survey->sections()
            ->with('questions:id,section_id')  // eager load
            ->get()
            ->flatMap(function ($section) {
                return $section->questions->pluck('id');
            });

        // 3. Check if any question under the survey has answers
        $hasQuestionAnswers = QuestionAnswer::whereIn('question_id', $questionIds)->exists();

        if ($hasQuestionAnswers) {
            return redirect()->route('surveys.index')
                ->with('error', 'Cannot delete this survey because answers exist for its questions.');
        }

        // 4. Soft delete all sections
        foreach ($survey->sections as $section) {
            $section->delete();
        }

        // 5. Soft delete the survey itself
        $survey->delete();

        return redirect()->route('surveys.index')
            ->with('success', 'Survey and its sections deleted successfully.');
    }



}
