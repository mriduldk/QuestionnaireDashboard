<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Section;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class QuestionAdminController extends Controller
{
    public function index(Request $request)
    {
        /*$questions = Question::with('section')->get();
        return view('admin.questions.index', compact('questions'));*/

        $surveys = Survey::all();

        $sections = collect(); // empty by default
        if ($request->filled('survey_id')) {
            $sections = Section::where('survey_id', $request->survey_id)->get();
        }

        $query = Question::with('section.survey');

        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        } elseif ($request->filled('survey_id')) {
            $query->whereHas('section', function ($q) use ($request) {
                $q->where('survey_id', $request->survey_id);
            });
        }

        $questions = $query->get();
        //$questions = $query->paginate(10);

        return view('admin.questions.index', compact('questions', 'surveys', 'sections'));
    }

    public function create()
    {
        $surveys = Survey::all();
        //$sections = Section::with('survey')->get();
        //$allQuestions = Question::all(); // For parent question dropdown
        return view('admin.questions.create', compact('surveys'));
    }
    public function getBySection($sectionId)
    {
        $questions = Question::where('section_id', $sectionId)->get();
        return response()->json($questions);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'survey_id' => 'required|exists:surveys,id',
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
            'survey_id' => $request->survey_id,
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
        //$sections = Section::with('survey')->get();
        $sections = Section::with('survey')->get();
        $surveys = Survey::all();

        return view('admin.questions.edit', compact('question', 'sections', 'surveys'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'survey_id' => 'required|exists:surveys,id',
            'section_id' => 'required|exists:sections,id',
            'parent_id' => 'nullable|exists:questions,id',
            'question_text' => 'required|string',
            'type' => 'required|in:text,number,radio,checkbox,select,textarea',
            'is_required' => 'boolean',
            'metadata' => 'nullable|array',
            'conditional_question_id' => 'nullable|exists:questions,id',
            'conditional_operator' => 'nullable|string',
            'conditional_value' => 'nullable|string',
        ]);

        // Prepare conditional logic if all fields are filled
        $conditionalLogic = null;
        if ($request->filled('conditional_question_id') && $request->filled('conditional_operator') && $request->filled('conditional_value')) {
            $conditionalLogic = [
                'show_if' => [
                    'question_id' => $request->conditional_question_id,
                    'operator' => $request->conditional_operator,
                    'value' => $request->conditional_value,
                ]
            ];
        }

        $question->update([
            'survey_id' => $request->survey_id,
            'section_id' => $request->section_id,
            'parent_id' => $request->parent_id,
            'question_text' => $request->question_text,
            'type' => $request->type,
            'is_required' => $request->has('is_required'),
            'metadata' => $request->metadata,
            'conditional_logic' => $conditionalLogic,
        ]);

        return redirect()->route('questions.index')->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('questions.index')->with('success', 'Question deleted.');
    }
}
