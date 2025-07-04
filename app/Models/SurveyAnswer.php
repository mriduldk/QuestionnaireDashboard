<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SurveyAnswer extends Model
{
    use HasFactory;

    protected $table = 'survey_answers';

    protected $primaryKey = 'survey_answer_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'survey_answer_id',
        'district',
        'sub_division',
        'block',
        'vcdc',
        'village',
        'name',
        'phone_number',
        'age',
        'gender',
        'voter_id',
        'caste',
        'house_hold_member',
        'house_hold_member_other',
        'household_livelihood_activities',
        'household_livelihood_activity_other',
        'average_annual_income',
        'status',
        'user_id',
        'updated',
    ];

    protected $casts = [
        'house_hold_member' => 'array',
        'household_livelihood_activities' => 'array',
        'updated' => 'boolean',
    ];
}
