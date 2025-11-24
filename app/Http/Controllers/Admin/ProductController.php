<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;

class ProductController extends Controller
{

    public function index()
    {
        // eager load category
        $products = Product::with('category')->latest()->paginate(12);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('title')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'product_code' => 'nullable|string',
            'moq' => 'nullable|string',
            'fob' => 'nullable|string',
            'images.*' => 'nullable|image|max:5120',
        ]);

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $img) {
                $path = $img->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('title')->get();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'product_code' => 'nullable|string|max:255',
            'moq' => 'nullable|string|max:255',
            'fob' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|max:5120',
        ]);

        // Update basic product info first
        $product->update($data);

        // If new images are uploaded → delete all old and replace
        if ($request->hasFile('images')) {
            // 1️⃣ Delete all old image files & DB records
            foreach ($product->images as $oldImage) {
                \Storage::disk('public')->delete($oldImage->path);
                $oldImage->delete();
            }

            // 2️⃣ Upload and save new images
            foreach ($request->file('images') as $index => $img) {
                $path = $img->store('products', 'public');
                \App\Models\ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }


    public function destroy(Product $product)
    {
        foreach ($product->images as $img) {
            \Storage::disk('public')->delete($img->path);
            $img->delete();
        }
        $product->delete();
        return back()->with('success', 'Product deleted.');
    }
}
