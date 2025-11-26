<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'product_code',
        'moq',
        'fob',
        'price',
        'discounted_price',
        'extra_description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Main product images (ProductImage table)
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    // Extra / customize images (ExtraImage table)
    public function extraImages()
    {
        return $this->hasMany(ExtraImage::class)->orderBy('sort_order');
    }
}
