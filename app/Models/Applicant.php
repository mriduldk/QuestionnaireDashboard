<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Applicant extends Model
{
    use HasFactory;

    // Optional: if your table name isn't the plural of the model
    protected $table = 'applicants';

    // Fields that can be mass-assigned
    protected $fillable = [
        'roll',
        'name',
        'phone',
        'father_name',
        'address',
        'post_name',
        'scheme_name',
        'venue',
        'date',
        'time',
        'otp',
        'otp_valid_upto',
    ];

    // Optional: cast date/time fields
    protected $casts = [
        'date' => 'date',
    ];
}
