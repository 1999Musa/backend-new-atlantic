<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductSlider;
use Illuminate\Http\Request;

class ProductSliderController extends Controller
{
    // Admin Views
    public function index()
    {
        $sliders = ProductSlider::latest()->get();
        return view('admin.product-sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.product-sliders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:40960'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        ProductSlider::create($data);

        return redirect()->route('admin.product-sliders.index')->with('success', 'Product added successfully.');
    }

    public function edit(ProductSlider $productSlider)
    {
        return view('admin.product-sliders.edit', compact('productSlider'));
    }

    public function update(Request $request, ProductSlider $productSlider)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:40960'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $productSlider->update($data);

        return redirect()->route('admin.product-sliders.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(ProductSlider $productSlider)
    {
        $productSlider->delete();
        return redirect()->route('admin.product-sliders.index')->with('success', 'Product deleted successfully.');
    }

    // API for React
    public function apiIndex()
    {
        return response()->json(ProductSlider::latest()->get(), 200);
    }
}

