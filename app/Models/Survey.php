<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'status'];
    public function sections() {
        return $this->hasMany(Section::class);
    }
    public function surveyAnswers()
    {
        return $this->hasMany(SurveyAnswer::class, 'survey_id');
    }


}
