<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    // GET /api/categories
    public function index()
    {
        // load products and their images
        $categories = Category::with(['products.images'])->get();

        // shape response for frontend
        $payload = $categories->map(function ($cat) {
            return [
                'id' => $cat->id,
                'title' => $cat->title,
                'description' => $cat->description,
                'heroImage' => $cat->hero_image ? url(\Storage::url($cat->hero_image)) : null,
                // products array. each product has images (urls)
                'products' => $cat->products->map(function ($p) {
                    return [
                        'id' => $p->id,
                        'productName' => $p->name,
                        'description' => $p->description,
                        'productCode' => $p->product_code,
                        'moq' => $p->moq,
                        'fob' => $p->fob,
                        'images' => $p->images->map(fn($img) => url(\Storage::url($img->path)))->toArray(),
                    ];
                })->toArray(),
            ];
        });

        return response()->json($payload);
    }
}
