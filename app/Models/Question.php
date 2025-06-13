<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Section;

class Question extends Model
{
    protected $fillable = ['section_id', 'parent_id', 'question_text', 'type', 'is_required', 'metadata', 'conditional_logic'];
    protected $casts = [
        'metadata' => 'array',
        'conditional_logic' => 'array',
        'is_required' => 'boolean',
    ];

    public function section() {
        return $this->belongsTo(\App\Models\Section::class);
    }

    public function subQuestions() {
        return $this->hasMany(Question::class, 'parent_id');
    }

    public function parent() {
        return $this->belongsTo(Question::class, 'parent_id');
    }


}
