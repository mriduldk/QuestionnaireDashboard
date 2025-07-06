<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;

    protected $fillable = ['survey_id', 'title', 'order'];
    public function questions() {
        return $this->hasMany(Question::class);
    }

    public function survey() {
        return $this->belongsTo(Survey::class);
    }

}
