<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionAnswer;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Survey;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SectionAdminController extends Controller
{
    public function index(Request $request)
    {
        /*$sections = Section::with('questions', 'survey')->get();
        return view('admin.sections.index', compact('sections'));*/

        $surveys = Survey::all();
        $query = Section::with('survey');

        if ($request->has('survey_id') && $request->survey_id) {
            $query->where('survey_id', $request->survey_id);
        }

        $sections = $query->orderBy('order')->get();
        //$sections = $query->orderBy('order')->paginate(10); // not ->get()

        return view('admin.sections.index', compact('sections', 'surveys'));
    }

    public function create(Request $request)
    {
        $surveys = \App\Models\Survey::pluck('title', 'id'); // [id => title]
        $selectedSurveyId = $request->query('survey_id');
        return view('admin.sections.create', compact('surveys', 'selectedSurveyId'));

        // $surveyId = $request->query('survey_id');
        // $survey = Survey::findOrFail($surveyId);
        // return view('admin.sections.create', compact('survey'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'survey_id' => 'required|exists:surveys,id',
            'title' => 'required|string|max:255',
            'order' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Section::create($request->only('survey_id', 'title', 'order'));

        return redirect()->route('sections.create', ['survey_id' => $request->survey_id])
                         ->with('success', 'Section added successfully.');
    }

    public function show(Section $section)
    {
        //$section->load('questions');
        $section->load(['survey', 'questions']);
        return view('admin.sections.show', compact('section'));
    }

    public function edit(Section $section)
    {
        //$survey = $section->survey;
        $surveys = Survey::pluck('title', 'id'); // id => title array
        return view('admin.sections.edit', compact('section', 'surveys'));
        //return view('admin.sections.edit', compact('section', 'survey'));
    }

    public function update(Request $request, Section $section)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $section->update($request->only('title', 'order'));

        return redirect()->route('sections.index')
                         ->with('success', 'Section updated successfully.');
    }

    public function destroy(Section $section)
    {
        // Get IDs of all questions in this section
        $questionIds = $section->questions()->pluck('id');

        // Check if any question has answers
        $hasAnswers = QuestionAnswer::whereIn('question_id', $questionIds)->exists();

        if ($hasAnswers) {
            return redirect()->route('sections.index')
                ->with('error', 'Cannot delete this section because answers exist for its questions.');
        }

        $section->delete(); // Soft delete

        return redirect()->route('sections.index')
            ->with('success', 'Section deleted successfully.');
    }


    public function getBySurvey($surveyId)
    {
        $sections = Section::where('survey_id', $surveyId)->get();
        return response()->json($sections);
    }

}
