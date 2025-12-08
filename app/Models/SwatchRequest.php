<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SwatchRequest extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'product_code',
        'product_name',
        'name',
        'email',
        'phone_country',
        'phone_number',
        'address',
        'message',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(UserLogin::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

