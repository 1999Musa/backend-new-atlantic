<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','path','sort_order'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // return full URL helper
    public function getUrlAttribute()
    {
        return $this->path ? \Storage::url($this->path) : null;
    }
}
