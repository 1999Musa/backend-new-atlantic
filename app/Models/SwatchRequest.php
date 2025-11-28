<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SwatchRequest extends Model
{
    protected $fillable = [
        'product_id', // Add this
        'name', 'email', 'phone_country', 'phone_number', 'address', 'message', 'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}