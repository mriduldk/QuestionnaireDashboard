<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Section;

class Survey extends Model
{
    protected $fillable = ['title', 'description', 'status'];
    public function sections() {
        return $this->hasMany(Section::class);
    }
    public function surveyAnswers()
    {
        return $this->hasMany(SurveyAnswer::class, 'survey_id');
    }


}
