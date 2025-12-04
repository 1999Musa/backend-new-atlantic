<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token', // ✅ ADD THIS
    ];

    protected $hidden = [
        'password',
        'api_token', // optional hide
    ];
}

