<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sustainability extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_image',
        'title',
        'image',
        'description',
    ];
}
