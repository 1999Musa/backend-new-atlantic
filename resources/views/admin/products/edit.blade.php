@extends('admin.layout')

@section('title', 'Edit Product')

@section('content')

<!-- Header -->
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        Edit Product: <span class="text-indigo-600">{{ $product->name }}</span>
    </h1>
    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-2 text-sm text-gray-600 hover:text-indigo-600 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Products
    </a>
</div>

<!-- Form Card -->
<div class="bg-white rounded-lg shadow-md border border-gray-200">
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="p-6 md:p-8">
            <div class="space-y-6">

                <!-- Product Name -->
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Edit Product's Name
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                           value="{{ old('name', $product->name) }}"
                           required>
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Category <span class="text-red-600">*</span>
                    </label>
                    <select id="category_id"
                            name="category_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            required>
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Product Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Product Code -->
                    <div>
                        <label for="product_code" class="block text-sm font-semibold text-gray-700 mb-2">
                            Product Code <span class="text-gray-400">(Optional)</span>
                        </label>
                        <input type="text"
                               id="product_code"
                               name="product_code"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                               value="{{ old('product_code', $product->product_code) }}"
                               placeholder="e.g., SKU-12345">
                        @error('product_code')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- MOQ -->
                    <div>
                        <label for="moq" class="block text-sm font-semibold text-gray-700 mb-2">
                            MOQ <span class="text-gray-400">(Optional)</span>
                        </label>
                        <input type="text"
                               id="moq"
                               name="moq"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                               value="{{ old('moq', $product->moq) }}"
                               placeholder="e.g., 500 units">
                        @error('moq')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- FOB -->
                    <div>
                        <label for="fob" class="block text-sm font-semibold text-gray-700 mb-2">
                            FOB <span class="text-gray-400">(Optional)</span>
                        </label>
                        <input type="text"
                               id="fob"
                               name="fob"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                               value="{{ old('fob', $product->fob) }}"
                               placeholder="e.g., $10.00">
                        @error('fob')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Description <span class="text-gray-400">(Optional)</span>
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                              placeholder="Write a detailed description for this product...">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Product Images -->
                <div>
                    <label for="images" class="block text-sm font-semibold text-gray-700 mb-2">
                        Product Images <span class="text-gray-400">(Optional)</span>
                    </label>
                    
                    <!-- Image Preview -->
                    @if($product->images->count())
                        <div class="mb-4 grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-4">
                            @foreach($product->images as $img)
                                <div class="relative group">
                                    <img src="{{ Storage::url($img->path) }}" alt="Product Image" class="w-24 h-24 object-cover rounded-lg shadow-sm border border-gray-200">
                                    <!-- Add a remove button for each image if your controller supports it -->
                                    <!-- <button type="button" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 w-6 h-6 flex items-center justify-center shadow-md opacity-0 group-hover:opacity-100 transition-opacity">&times;</button> -->
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <input type="file"
                           id="images"
                           name="images[]"
                           multiple
                           class="w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors cursor-pointer">
                    <p class="text-xs text-gray-500 mt-2">Uploading new images will replace existins.</p>
                    
                    @error('images')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        <!-- Form Footer -->
        <div class="bg-gray-50 px-6 py-4 rounded-b-lg border-t border-gray-200">
            <div class="flex justify-end items-center gap-4">
                <a href="{{ route('admin.products.index') }}"
                   class="py-2 px-4 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                    Cancel
                </a>
                <button type="submit"g one
                        class="flex items-center gap-2 py-2 px-4 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Update Product
                </button>
            </div>
        </div>
    </form>
</div>
@endsection