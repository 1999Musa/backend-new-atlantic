@extends('admin.layout')

@section('title', 'Edit Hero Slide')

@section('content')
<div class="max-w-5xl mx-auto py-10">
    
    {{-- Header & Navigation --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Hero Slider</h1>
            <p class="text-sm text-gray-500 mt-1">Update the visuals and messaging for your homepage banner.</p>
        </div>
        <a href="{{ route('admin.hero-sliders.index') }}" class="text-sm text-gray-500 hover:text-gray-900 flex items-center gap-1 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to List
        </a>
    </div>

    <form action="{{ route('admin.hero-sliders.update', $hero_slider->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-gray-200">
                
                {{-- Left Column: Image Preview & Upload --}}
                <div class="p-8 bg-gray-50 md:col-span-1 flex flex-col">
                    <label class="block text-sm font-semibold text-gray-700 mb-4">Hero Image</label>
                    
                    {{-- Image Preview Container --}}
                    <div class="relative group w-full aspect-video bg-gray-200 rounded-xl overflow-hidden border border-gray-300 shadow-inner mb-4">
                        <img id="preview-img" 
                             src="{{ asset('storage/' . $hero_slider->hero_image) }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" 
                             alt="Slider Preview">
                        
                        {{-- Overlay hint --}}
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <p class="text-white text-xs font-medium">Current Preview</p>
                        </div>
                    </div>

                    {{-- Custom Upload Button --}}
                    <div class="mt-auto">
                        <label for="hero_image_input" class="cursor-pointer flex items-center justify-center w-full px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-blue-400 transition-all">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Change Image
                        </label>
                        <input type="file" id="hero_image_input" name="hero_image" class="hidden" accept="image/*" onchange="previewImage(event)">
                        <p class="text-xs text-gray-400 mt-2 text-center">Recommended: 1920x1080px</p>
                    </div>
                </div>

                {{-- Right Column: Content Inputs --}}
                <div class="p-8 md:col-span-2 space-y-6">
                    
                    {{-- Title Input --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Headline Title</label>
                        <input type="text" name="title" value="{{ $hero_slider->title }}"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none shadow-sm placeholder-gray-400"
                               placeholder="e.g., Welcome to Arbella">
                    </div>

                    {{-- Footer Actions --}}
                    <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                        <a href="{{ route('admin.hero-sliders.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white hover:bg-gray-50 rounded-lg transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="px-8 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all transform active:scale-95">
                            Update Slider
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Script for Instant Image Preview --}}
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('preview-img');
            output.src = reader.result;
        };
        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection