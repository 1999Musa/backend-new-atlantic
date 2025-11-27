@extends('admin.layout')

@section('title', 'Edit Product')

@section('content')
    <div class="max-w-4xl mx-auto p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Edit Product: {{ $product->name }}</h2>
            <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back to List</a>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6 bg-white p-8 rounded-xl shadow-sm border border-gray-100">

            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
                <select name="category_id" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5 border">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Product Name</label>
                <input type="text" name="name" value="{{ $product->name }}" 
                       class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5 border" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description_editor">{{ $product->description }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Extra Description</label>
                <textarea name="extra_description" id="extra_description_editor">{{ $product->extra_description }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Product Code</label>
                    <input name="product_code" value="{{ $product->product_code }}"
                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5 border" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">MOQ</label>
                    <input name="moq" value="{{ $product->moq }}" 
                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5 border" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">FOB</label>
                    <input name="fob" value="{{ $product->fob }}" 
                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5 border" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Main Price</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-500">$</span>
                        <input type="number" step="0.01" name="price" value="{{ $product->price }}"
                            class="pl-7 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5 border" />
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Discounted Price</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-500">$</span>
                        <input type="number" step="0.01" name="discounted_price" value="{{ $product->discounted_price }}"
                            class="pl-7 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5 border" />
                    </div>
                </div>
            </div>

            <hr class="border-gray-100 my-2">

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-3">Main Product Images</label>

                <div id="oldMainImages" class="flex gap-4 flex-wrap mb-3">
                    @foreach($product->images as $img)
                        <div class="relative group w-24 h-24 border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                            <img src="{{ Storage::url($img->path) }}" class="w-full h-full object-cover" />
                            <button type="button"
                                    class="absolute top-1 right-1 bg-white text-red-600 rounded-full p-1 shadow hover:bg-red-50 transition opacity-0 group-hover:opacity-100"
                                    onclick="removeImage({{ $img->id }}, 'remove_main', event)" title="Remove Image">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    @endforeach
                </div>

                <input type="hidden" name="remove_main" id="remove_main">
                <input type="file" name="images[]" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition" />
                <p class="text-xs text-gray-400 mt-1">Uploading new images here will replace the existing ones.</p>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <label class="block text-sm font-semibold text-indigo-700 mb-3">Customize Page Images</label>

                <div id="oldExtraImages" class="flex gap-4 flex-wrap mb-3">
                    @foreach($product->extraImages as $img)
                        <div class="relative group w-24 h-24 border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                            <img src="{{ Storage::url($img->path) }}" class="w-full h-full object-cover" />
                            <button type="button"
                                    class="absolute top-1 right-1 bg-white text-red-600 rounded-full p-1 shadow hover:bg-red-50 transition opacity-0 group-hover:opacity-100"
                                    onclick="removeImage({{ $img->id }}, 'remove_extra', event)" title="Remove Image">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    @endforeach
                </div>

                <input type="hidden" name="remove_extra" id="remove_extra">
                <input type="file" name="extra_images[]" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition" />
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-800 bg-white border border-gray-300 rounded-lg transition-colors">Cancel</a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-medium text-sm rounded-lg hover:bg-indigo-700 shadow-sm transition-colors">
                    Update Product
                </button>
            </div>

        </form>
    </div>

    {{-- 1. CKEditor CDN --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

    {{-- 2. Custom Styles for CKEditor List Support --}}
    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
        }
        /* Tailwind resets lists, so we strictly re-enable them inside editor content */
        .ck-content ul {
            list-style-type: disc !important;
            padding-left: 1.5rem !important;
            margin-bottom: 1rem;
        }
        .ck-content ol {
            list-style-type: decimal !important;
            padding-left: 1.5rem !important;
            margin-bottom: 1rem;
        }
        .ck-content h2 { font-size: 1.5em; font-weight: bold; margin-bottom: 0.5rem; }
        .ck-content h3 { font-size: 1.25em; font-weight: bold; margin-bottom: 0.5rem; }
        .ck-content p { margin-bottom: 1rem; }
    </style>

    <script>
        // Init CKEditor for Description
        ClassicEditor
            .create(document.querySelector('#description_editor'))
            .catch(error => { console.error(error); });

        // Init CKEditor for Extra Description
        ClassicEditor
            .create(document.querySelector('#extra_description_editor'))
            .catch(error => { console.error(error); });

        // Image Removal Logic
        function removeImage(id, field, event) {
            event = event || window.event;
            event.preventDefault();

            // Get hidden input
            let input = document.getElementById(field);
            let current = input.value ? input.value.split(',') : [];

            // Add removed image ID
            current.push(id);
            input.value = current.join(',');

            // Remove image from DOM
            const box = event.target.closest('.relative');
            if (box) {
                // simple fade out effect
                box.style.opacity = '0';
                setTimeout(() => box.remove(), 300);
            }
        }
    </script>
@endsection