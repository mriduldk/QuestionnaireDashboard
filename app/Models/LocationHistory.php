<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LocationHistory extends Model
{
    use HasFactory;

    protected $table = 'location_histories';
    protected $primaryKey = 'location_history_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'location_history_id',
        'user_id',
        'latitude',
        'longitude',
        'created_at',
        'updated_at',
        'updated'
    ];
}
