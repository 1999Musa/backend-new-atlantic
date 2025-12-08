<?php

namespace App\Models;
use App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class CustomRequest extends Model
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
        'quantity',
        'message',
        'attachment',
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

