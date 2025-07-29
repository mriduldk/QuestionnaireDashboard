<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function subDivisions()
    {
        return $this->hasMany(SubDivision::class);
    }
}
