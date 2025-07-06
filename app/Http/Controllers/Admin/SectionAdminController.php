<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        return view('admin.sections.create', compact('surveys'));

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

        return redirect()->route('sections.index')
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
        $surveyId = $section->survey_id;
        $section->delete();

        return redirect()->route('sections.index')
                         ->with('success', 'Section deleted.');
    }

    public function getBySurvey($surveyId)
    {
        $sections = Section::where('survey_id', $surveyId)->get();
        return response()->json($sections);
    }

}
