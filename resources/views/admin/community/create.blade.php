@extends('admin.layout')

@section('title', 'Upload Community Images')

@section('content')
<div class="container mx-auto">
    <!-- Header with Back Button -->
    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.community.index') }}" class="flex items-center gap-2 bg-gray-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-600 shadow-md transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Community Sections
        </a>
    </div>

    <!-- Upload Community Images Form -->
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">Upload Community Images</h2>

        <form action="{{ route('admin.community.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Section Type -->
            <div class="mb-6">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Section Type</label>
                <select name="type" id="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition" required>
                    <option value="" disabled selected>Select a section</option>
                    <option value="hero" {{ old('type') == 'hero' ? 'selected' : '' }}>Hero Section</option>
                    <option value="employees" {{ old('type') == 'employees' ? 'selected' : '' }}>Community for Employees</option>
                    <option value="gallery" {{ old('type') == 'gallery' ? 'selected' : '' }}>Gallery</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Image(s) Upload -->
            <div class="mb-6">
                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Upload Image(s)</label>
                <input type="file" name="images[]" id="images" multiple required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                 @error('images')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
                 @error('images.*')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end border-t pt-6 mt-6">
                <button type="submit" class="flex items-center gap-2 bg-emerald-500 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-emerald-600 shadow-md transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Upload Images
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
