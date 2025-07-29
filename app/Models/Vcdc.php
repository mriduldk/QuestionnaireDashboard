<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vcdc extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'block_id'];

    public function block()
    {
        return $this->belongsTo(Block::class);
    }
}
