<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveySection;
use App\Models\Survey;
use Illuminate\Http\Request;

class SurveySectionController extends Controller
{
    /**
     * Display a listing of survey sections.
     */
    public function index()
    {
        $sections = SurveySection::with('survey')->latest()->paginate(10);
        return view('admin.survey_sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new survey section.
     */
    public function create()
    {
        $surveys = Survey::all();
        return view('admin.survey_sections.create', compact('surveys'));
    }

    /**
     * Store a newly created survey section in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'survey_id' => 'required|exists:surveys,id',
            'components'=> 'nullable|json',
        ]);

        SurveySection::create($validated);

        return redirect()->route('survey-sections.index')->with('success', 'Survey Section created successfully!');
    }

    /**
     * Show the form for editing the specified survey section.
     */
    public function edit(SurveySection $surveySection)
    {
        $surveys = Survey::pluck('title', 'id');
        return view('survey_sections.edit', compact('surveySection', 'surveys'));
    }

    /**
     * Update the specified survey section in storage.
     */
    public function update(Request $request, SurveySection $surveySection)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'survey_id' => 'required|exists:surveys,id',
            'components'=> 'nullable|json',
        ]);

        $surveySection->update($validated);

        return redirect()->route('survey-sections.index')->with('success', 'Survey Section updated successfully!');
    }

    /**
     * Remove the specified survey section from storage.
     */
    public function destroy(SurveySection $surveySection)
    {
        $surveySection->delete();

        return redirect()->route('survey-sections.index')->with('success', 'Survey Section deleted successfully!');
    }
}
