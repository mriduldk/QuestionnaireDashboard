<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MultipleQuestionAnswer extends Model
{
    use HasUuids;

    protected $table = 'multiple_question_answers';
    protected $primaryKey = 'multiple_question_answer_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'multiple_question_answer_id',
        'question_answer_id',
        'survey_answer_id',
        'question_id',
        'section_id',
        'survey_id',
        'type',
        'answer_text',
        'is_answered',
        'is_multiple',
        'sl_no',
    ];

    protected $casts = [
        'is_answered' => 'boolean',
        'is_multiple' => 'boolean',
    ];


}
