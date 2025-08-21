<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveySection extends Model
{
    use HasFactory;

    protected $table = 'survey_sections';

    protected $fillable = [
        'title',
        'survey_id',
        'components',
    ];

    // Cast components JSON to array automatically
    protected $casts = [
        'components' => 'array',
    ];

    // If you have a Survey model, you can relate it
    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }
}
