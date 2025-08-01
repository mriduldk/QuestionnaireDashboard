<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CallLetterDownload extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'ip_address',
        'post_name',
        'applicant_id',
    ];

    public $timestamps = false; // only `created_at` is used

    protected $dates = ['created_at'];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
