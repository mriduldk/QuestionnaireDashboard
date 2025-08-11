<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    protected $fillable = ['survey_id', 'section_id', 'parent_id', 'question_text', 'type', 'is_required', 'is_multiple', 'metadata', 'conditional_logic', 'repeating', 'header'];
    protected $casts = [
        'metadata' => 'array',
        'conditional_logic' => 'array',
        'is_required' => 'boolean',
        'is_multiple' => 'boolean',
        'repeating' => 'boolean', // added
        'header' => 'boolean',    // added
    ];

    public function section()
    {
        return $this->belongsTo(\App\Models\Section::class)->whereNull('deleted_at');
    }

    public function subQuestions()
    {
        return $this->hasMany(Question::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Question::class, 'parent_id');
    }


}
