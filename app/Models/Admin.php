<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory;
    
    protected $fillable = ['name', 'email', 'phone', 'designation', 'password', 'role', 'is_deleted', 'created_by', 'modified_by'];
    protected $hidden = ['password'];
}
