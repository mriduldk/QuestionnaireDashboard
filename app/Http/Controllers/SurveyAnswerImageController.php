<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SurveyAnswerImage;
use Illuminate\Support\Facades\Storage;

class SurveyAnswerImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'survey_answer_id' => 'required',
            'caption' => 'nullable|string',
            'image' => 'required|image|max:2048'
        ]);

        $path = $request->file('image')->store('survey_images', 'public');

        $image = SurveyAnswerImage::create([
            'survey_answer_id' => $request->survey_answer_id,
            'image_url' => Storage::url($path),
            'caption' => $request->caption
        ]);

        return ApiResponse::success(200, 'Survey answer updated', "image", $image);
    }

    public function index($survey_answer_id)
    {
        $images = SurveyAnswerImage::where('survey_answer_id', $survey_answer_id)->get();
        return response()->json($images);
    }
}
