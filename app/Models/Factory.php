<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factory extends Model
{
    protected $fillable = [
        'hero_image',
        'gallery',
        'certificates',
        'clients',
    ];

    protected $casts = [
        'gallery' => 'array',
        'certificates' => 'array',
        'clients' => 'array',
    ];
}
