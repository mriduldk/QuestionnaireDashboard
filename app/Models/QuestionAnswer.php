<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestionAnswer extends Model
{
    use HasFactory;

    protected $table = 'question_answers';

    protected $primaryKey = 'question_answer_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'question_answer_id',
        'survey_answer_id',
        'question_id',
        'section_id',
        'survey_id',
        'type',
        'answer_text',
        'is_answered',
        'user_id',
        'updated',
    ];

    protected $casts = [
        'is_answered' => 'boolean',
    ];
}
