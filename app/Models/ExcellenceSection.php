<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcellenceSection extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'images'];

    protected $casts = [
        'images' => 'array', // JSON -> array automatically
    ];
}
