<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;

class SurveyController extends Controller
{
    public function index() {
        $surveys = Survey::with('sections.questions')->get();
        return response()->json($surveys);
    }

    public function show($id) {
        $survey = Survey::with('sections.questions')->findOrFail($id);
        return response()->json($survey);
    }

    public function store(Request $request) {
        $survey = Survey::create($request->only(['title', 'description', 'status']));
        return response()->json($survey, 201);
    }


}
