<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;

class AnswerController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user(); // or however you identify users

        foreach ($request->answers as $answer) {
            Answer::create([
                'question_id' => $answer['question_id'],
                'user_id' => $user->id,
                'response' => is_array($answer['response']) ? json_encode($answer['response']) : $answer['response'],
            ]);
        }

        return response()->json(['message' => 'Answers submitted successfully']);
    }

}
