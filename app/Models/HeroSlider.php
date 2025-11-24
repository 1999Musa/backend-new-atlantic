<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlider extends Model
{
    protected $fillable = ['title', 'subtitle', 'hero_image'];

    protected $casts = [
        'images' => 'array', // JSON automatically converted to array
    ];
}
