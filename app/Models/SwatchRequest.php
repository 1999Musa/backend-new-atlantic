<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SwatchRequest extends Model
{
    protected $fillable = [
        'name', 'email', 'phone_country', 'phone_number', 'address', 'message'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
