<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'leave_application_id',
        'date_from',
        'date_to',
        'attachment',
        'leave_type',
        'reason',
        'submitted_by',
        'submitted_on',
        'is_deleted',
        'is_approved',
        'remarks',
        'approved_by',
        'approved_on',
    ];

    protected $casts = [
        'submitted_on' => 'datetime',
        'approved_on'  => 'datetime',
        'is_deleted'   => 'boolean',
    ];

    // Relationships
    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitted_by', 'user_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'user_id');
    }
}
