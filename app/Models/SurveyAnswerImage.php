<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyAnswerImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_answer_id',
        'image_url',
        'caption',
    ];

    public function surveyAnswer()
    {
        return $this->belongsTo(SurveyAnswer::class, 'survey_answer_id', 'survey_answer_id');
    }
}
