<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['section_id', 'question_text', 'type', 'is_required', 'metadata', 'conditional_logic'];
    protected $casts = [
        'metadata' => 'array',
        'conditional_logic' => 'array',
        'is_required' => 'boolean',
    ];
}
