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
        // eager load category + images for thumbnails
        $products = Product::with(['category', 'images'])
            ->latest()
            ->paginate(12);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('title')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'extra_description' => 'nullable|string',
            'product_code' => 'nullable|string|max:255',
            'moq' => 'nullable|string|max:255',
            'fob' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'discounted_price' => 'nullable|numeric',
            'images.*' => 'image|max:5120',
            'extra_images.*' => 'image|max:5120',
        ]);

        $product = Product::create($validated);

        // Save main images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $img) {
                $path = $img->store('products', 'public');
                $product->images()->create([
                    'path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        // Save extra/custom images
        if ($request->hasFile('extra_images')) {
            foreach ($request->file('extra_images') as $index => $img) {
                $path = $img->store('products', 'public');
                $product->extraImages()->create([
                    'path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }


    public function edit(Product $product)
    {
        $categories = Category::orderBy('title')->get();

        // Load images, customize images, swatches etc.
        $product->load([
            'images',
            'extraImages',
        ]);

        return view('admin.products.edit', compact('product', 'categories'));
    }


public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'extra_description' => 'nullable|string',
            'product_code' => 'nullable|string|max:255',
            'moq' => 'nullable|string|max:255',
            'fob' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'discounted_price' => 'nullable|numeric',
            'images.*' => 'image|max:5120',
            'extra_images.*' => 'image|max:5120',
        ]);

        $product->update($validated);

        // 1. HANDLE MAIN IMAGES (REPLACE LOGIC)
        if ($request->hasFile('images')) {
            
            // 
            
            // A. Delete ALL existing main images from Storage & DB
            foreach ($product->images as $img) {
                // Delete physical file
                if (\Storage::disk('public')->exists($img->path)) {
                    \Storage::disk('public')->delete($img->path);
                }
                // Delete DB record
                $img->delete();
            }

            // B. Upload New Images
            foreach ($request->file('images') as $index => $img) {
                $path = $img->store('products', 'public');
                $product->images()->create([
                    'path' => $path,
                    'sort_order' => $index,
                ]);
            }
        } 
        // Only run the manual "remove_main" logic if we DIDN'T just wipe everything above
        elseif ($request->filled('remove_main')) {
            $ids = explode(',', $request->remove_main);
            $images = $product->images()->whereIn('id', $ids)->get();
            foreach ($images as $img) {
                \Storage::disk('public')->delete($img->path);
                $img->delete();
            }
        }


        // 2. HANDLE EXTRA IMAGES (Keep existing logic or apply replace logic here too?)
        // Assuming you want to keep Append/Delete logic for Extra, 
        // but if you want to replace extra images too, copy the logic from above.
        
        // Delete specific removed extra images
        if ($request->filled('remove_extra')) {
            $ids = explode(',', $request->remove_extra);
            $images = $product->extraImages()->whereIn('id', $ids)->get();
            foreach ($images as $img) {
                \Storage::disk('public')->delete($img->path);
                $img->delete();
            }
        }

        // Add new extra images (This appends. Change to replace if needed)
        if ($request->hasFile('extra_images')) {
            foreach ($request->file('extra_images') as $index => $img) {
                $path = $img->store('products', 'public');
                $product->extraImages()->create([
                    'path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    // GET single product for frontend customize page
    public function show(Product $product)
    {
        // Load both image tables
        $product->load(['images', 'extraImages']);

        // Convert main images → URLs
        $mainImages = $product->images->map(function ($img) {
            return asset('storage/' . $img->path);
        });

        // Convert custom images → URLs
        $customImages = $product->extraImages->map(function ($img) {
            return asset('storage/' . $img->path);
        });

        return response()->json([
            'id' => $product->id,
            'productName' => $product->name,
            'extraDescription' => $product->extra_description,
            'price' => $product->price,
            'discountedPrice' => $product->discounted_price,
            'productCode' => $product->product_code,

            // Main gallery images
            'images' => $mainImages,

            // Customize page images
            'customizeImages' => $customImages,
        ]);
    }

    public function destroy(Product $product)
    {
        // Delete product images
        foreach ($product->images as $img) {
            \Storage::disk('public')->delete($img->path);
            $img->delete();
        }

        $product->delete();

        return back()->with('success', 'Product deleted.');
    }
}
