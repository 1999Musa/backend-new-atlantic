@extends('admin.layout')

@section('title', 'Edit Product Slide')

@section('content')
<div class="max-w-5xl mx-auto py-10">
    
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit "{{ $productSlider->title }}"</h1>
            <p class="text-sm text-gray-500 mt-1">Update the product information and imagery for the slider.</p>
        </div>
        <a href="{{ url()->previous() }}" class="text-sm text-gray-500 hover:text-gray-900 flex items-center gap-1 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to List
        </a>
    </div>

    <form method="POST" action="{{ route('admin.product-sliders.update', $productSlider->id) }}" enctype="multipart/form-data">
        @csrf 
        @method('PUT')

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            
            <div class="grid grid-cols-1 md:grid-cols-12 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                
                {{-- Left Column: Image Management (4 cols) --}}
                <div class="md:col-span-4 p-8 bg-gray-50 flex flex-col">
                    <label class="block text-sm font-bold text-gray-700 mb-4">Product Image</label>
                    
                    {{-- Image Container --}}
                    <div class="relative group w-full aspect-square bg-white rounded-xl border-2 border-dashed border-gray-300 overflow-hidden shadow-sm hover:border-indigo-400 transition-colors">
                        
                        {{-- Current/Preview Image --}}
                        <img id="product-preview" 
                             src="{{ asset('storage/'.$productSlider->image) }}" 
                             class="w-full h-full object-contain p-2 transition-opacity duration-300"
                             alt="Product Preview">
                        
                        {{-- Hover Overlay --}}
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-white">
                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="text-sm font-medium">Change Image</span>
                        </div>

                        {{-- Hidden Input Triggered by clicking the container --}}
                        <input type="file" name="image" 
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                               onchange="updatePreview(this)">
                    </div>
                    
                    <p class="text-xs text-center text-gray-400 mt-3">Click image to upload new file.</p>
                </div>

                {{-- Right Column: Product Details (8 cols) --}}
                <div class="md:col-span-8 p-8 flex flex-col h-full">
                    
                    <div class="space-y-6 flex-grow">
                        {{-- Title Input --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Product Title</label>
                            <input type="text" name="title" value="{{ $productSlider->title }}"
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none shadow-sm placeholder-gray-400"
                                   placeholder="Enter product name">
                        </div>

                        {{-- Description Input --}}
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-semibold text-gray-700">Description</label>
                                <span class="text-xs text-gray-400 font-medium uppercase tracking-wide">Optional</span>
                            </div>
                            <textarea name="description" rows="5"
                                      class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none shadow-sm placeholder-gray-400 resize-y"
                                      placeholder="Add a brief description about the product...">{{ $productSlider->description }}</textarea>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="pt-8 mt-4 border-t border-gray-100 flex items-center justify-end gap-4">
                        <a href="{{ url()->previous() }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-lg transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 px-8 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-100 shadow-lg shadow-indigo-200 transition-all transform active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Update Product
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Script to handle immediate image preview --}}
<script>
    function updatePreview(input) {
        const preview = document.getElementById('product-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection