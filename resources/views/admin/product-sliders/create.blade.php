@extends('admin.layout')

@section('title', 'Add New Product')

@section('content')
<div class="max-w-5xl mx-auto py-10">
    
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="text-sm text-gray-500 mt-1">Create a new product slide for the homepage showcase.</p>
        </div>
        <a href="{{ route('admin.product-sliders.index') }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">
            Cancel & Return
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        {{-- Decorative Gradient Bar --}}
        <div class="h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 w-full"></div>

        <form method="POST" action="{{ route('admin.product-sliders.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 h-full">
                
                {{-- Left Column: Image Upload Zone --}}
                <div class="p-8 bg-gray-50 lg:col-span-1 border-r border-gray-100 flex flex-col">
                    <label class="block text-sm font-bold text-gray-700 mb-4">Product Image</label>
                    
                    {{-- Interactive Upload Box --}}
                    <div class="relative w-full aspect-square bg-white rounded-xl border-2 border-dashed border-gray-300 hover:border-indigo-500 hover:bg-indigo-50/20 transition-all cursor-pointer group overflow-hidden">
                        
                        {{-- Hidden Input --}}
                        <input type="file" name="image" 
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" 
                               required onchange="previewImage(this)">
                        
                        {{-- Placeholder State --}}
                        <div id="upload-placeholder" class="absolute inset-0 flex flex-col items-center justify-center text-center p-4">
                            <div class="w-12 h-12 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">Upload Image</span>
                            <span class="text-xs text-gray-400 mt-1">PNG, JPG up to 2MB</span>
                        </div>

                        {{-- Preview State (Hidden initially) --}}
                        <img id="image-preview" src="#" alt="Preview" class="absolute inset-0 w-full h-full object-contain p-4 hidden z-10 bg-white">
                    </div>
                    
                    <p class="text-xs text-center text-gray-400 mt-4">
                        Tip: Transparent PNGs work best.
                    </p>
                </div>

                {{-- Right Column: Form Details --}}
                <div class="p-8 lg:col-span-2 flex flex-col h-full">
                    <div class="space-y-6 flex-grow">
                        
                        {{-- Title Input --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Product Title</label>
                            <input type="text" name="title" placeholder="e.g. Wireless Headphones" required
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none shadow-sm placeholder-gray-400">
                        </div>

                        {{-- Description Input --}}
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-semibold text-gray-700">Description</label>
                                <span class="text-xs text-gray-400 font-medium bg-gray-100 px-2 py-0.5 rounded">Optional</span>
                            </div>
                            <textarea name="description" rows="5" placeholder="Write a catchy description..."
                                      class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none shadow-sm placeholder-gray-400 resize-none"></textarea>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="pt-8 mt-4 border-t border-gray-100 flex items-center justify-end gap-4">
                        <a href="{{ route('admin.product-sliders.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-lg transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 px-8 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-100 shadow-lg shadow-indigo-200 transition-all transform active:scale-95">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Save Product
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Script for Instant Preview --}}
<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('upload-placeholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection