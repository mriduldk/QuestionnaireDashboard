<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Section;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class QuestionAdminController extends Controller
{
    public function index()
    {
        $questions = Question::with('section')->get();
        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        $sections = Section::with('survey')->get();
        $allQuestions = Question::all(); // For parent question dropdown
        return view('admin.questions.create', compact('sections', 'allQuestions'));
        //return view('admin.questions.create', compact('sections'));
    }
    public function getBySection($sectionId)
    {
        $questions = Question::where('section_id', $sectionId)->get();
        return response()->json($questions);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section_id' => 'required|exists:sections,id',
            'parent_id' => 'nullable|exists:questions,id',
            'question_text' => 'required|string',
            'type' => 'required|in:text,number,radio,checkbox,select,textarea',
            'is_required' => 'boolean',
            'metadata' => 'nullable|array',
            'conditional_question_id' => 'nullable|integer|exists:questions,id',
            'conditional_operator' => 'nullable|string',
            'conditional_value' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $conditionalLogic = null;

        if ($request->filled('conditional_question_id') &&
            $request->filled('conditional_operator') &&
            $request->filled('conditional_value')) {
            $conditionalLogic = [
                'show_if' => [
                    'question_id' => (int) $request->conditional_question_id,
                    'operator' => $request->conditional_operator,
                    'value' => $request->conditional_value
                ]
            ];
        }

        //dd($parentId);

        Question::create([
            'section_id' => $request->section_id,
            'parent_id' => $request->parent_id,
            'question_text' => $request->question_text,
            'type' => $request->type,
            'is_required' => $request->has('is_required'),
            'metadata' => $request->metadata,
            'conditional_logic' => $conditionalLogic,
        ]);

        return redirect()->route('questions.index')->with('success', 'Question added successfully.');
    }

    public function show(Question $question)
    {
        return view('admin.questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        $sections = Section::with('survey')->get();
        return view('admin.questions.edit', compact('question', 'sections'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'parent_id' => 'nullable|exists:questions,id',
            'question_text' => 'required|string',
            'type' => 'required|in:text,number,radio,checkbox,select,textarea',
            'is_required' => 'boolean',
            'metadata' => 'nullable|array',
        ]);

        $question->update([
            'section_id' => $request->section_id,
            'parent_id' => $request->parent_id,
            'question_text' => $request->question_text,
            'type' => $request->type,
            'is_required' => $request->has('is_required'),
            'metadata' => $request->metadata,
        ]);

        return redirect()->route('questions.index')->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('questions.index')->with('success', 'Question deleted.');
    }
}
