<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyAdminController extends Controller
{
    public function index() {
        $surveys = Survey::all();
        return view('admin.surveys.index', compact('surveys'));
    }

    public function create() {
        return view('admin.surveys.create');
    }

    public function store(Request $request) {
        $survey = Survey::create($request->only(['title', 'description', 'status']));
        return redirect()->route('surveys.show', $survey);
    }

    public function show(Survey $survey) {
        $survey->load('sections.questions');
        return view('admin.surveys.show', compact('survey'));
    }
}
