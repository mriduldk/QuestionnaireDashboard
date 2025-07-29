<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Block extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sub_division_id'];

    public function subDivision()
    {
        return $this->belongsTo(SubDivision::class);
    }

    public function vcdcs()
    {
        return $this->hasMany(Vcdc::class);
    }
}

