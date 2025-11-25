@extends('admin.layout')

@section('title', 'Edit Product')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4">Edit Product: {{ $product->name }}</h2>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <!-- Category -->
        <div>
            <label class="block text-sm font-medium">Category</label>
            <select name="category_id" class="mt-1 block w-full border rounded p-2">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->title }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        <!-- Product Name -->
        <div>
            <label class="block text-sm font-medium">Product Name</label>
            <input name="name" value="{{ old('name', $product->name) }}" class="mt-1 block w-full border rounded p-2" />
            @error('name') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-medium">Description</label>
            <textarea name="description" class="mt-1 block w-full border rounded p-2">{{ old('description', $product->description) }}</textarea>
        </div>

        <!-- Extra Description -->
        <div>
            <label class="block text-sm font-medium">Extra Description</label>
            <textarea name="extra_description" class="mt-1 block w-full border rounded p-2">{{ old('extra_description', $product->extra_description) }}</textarea>
        </div>

        <!-- Product Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div>
                <label class="block text-sm font-medium">Product Code</label>
                <input name="product_code" value="{{ old('product_code', $product->product_code) }}" class="mt-1 block w-full border rounded p-2" />
            </div>
            <div>
                <label class="block text-sm font-medium">MOQ</label>
                <input name="moq" value="{{ old('moq', $product->moq) }}" class="mt-1 block w-full border rounded p-2" />
            </div>
            <div>
                <label class="block text-sm font-medium">FOB</label>
                <input name="fob" value="{{ old('fob', $product->fob) }}" class="mt-1 block w-full border rounded p-2" />
            </div>
        </div>

        <!-- Price & Discount Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium">Main Price</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="mt-1 block w-full border rounded p-2" />
            </div>
            <div>
                <label class="block text-sm font-medium">Discounted Price</label>
                <input type="number" step="0.01" name="discounted_price" value="{{ old('discounted_price', $product->discounted_price) }}" class="mt-1 block w-full border rounded p-2" />
            </div>
        </div>

        <!-- Images -->
        <div>
            <label class="block text-sm font-medium">Product Images</label>
            @if($product->images->count())
                <div class="flex gap-2 mb-2">
                    @foreach($product->images as $img)
                        <img src="{{ Storage::url($img->path) }}" class="w-24 h-24 object-cover rounded border" alt="Product Image">
                    @endforeach
                </div>
            @endif
            <input type="file" name="images[]" multiple class="mt-1" />
            <p class="text-xs text-gray-500 mt-1">Uploading new images will replace existing images.</p>
        </div>

        <!-- Actions -->
        <div class="flex gap-3 mt-4">
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border rounded">Cancel</a>
            <button class="px-4 py-2 bg-amber-400 text-white rounded">Update</button>
        </div>
    </form>
</div>
@endsection
