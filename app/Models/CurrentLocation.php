<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CurrentLocation extends Model
{
    use HasFactory;

    protected $table = 'current_locations';
    protected $primaryKey = 'current_location_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'current_location_id',
        'user_id',
        'latitude',
        'longitude',
        'created_at',
        'updated_at',
        'updated',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'user_id');
    }

}
