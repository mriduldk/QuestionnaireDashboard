<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\Survey;

class Section extends Model
{
    protected $fillable = ['survey_id', 'title', 'order'];
    public function questions() {
        return $this->hasMany(Question::class);
    }

    public function survey() {
        return $this->belongsTo(Survey::class);
    }

}
