<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceOrderItem extends Model
{
    protected $fillable = ['type','step','title','description','list_items'];

    protected $casts = [
        'list_items' => 'array',
    ];
}
