@extends('admin.layout')

@section('title', 'Create Factory Record')

@section('content')
<div class="container mx-auto">
    <!-- Header with Back Button -->
    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.factory.index') }}" class="flex items-center gap-2 bg-gray-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-600 shadow-md transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Factory Records
        </a>
    </div>

    <!-- Create Form -->
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">Create New Factory Record</h2>

        <form action="{{ route('admin.factory.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Hero Image -->
            <div class="mb-6">
                <label for="hero_image" class="block text-sm font-medium text-gray-700 mb-2">Hero Image</label>
                <input type="file" name="hero_image" id="hero_image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                @error('hero_image')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gallery Images -->
            <div class="mb-6">
                <label for="gallery" class="block text-sm font-medium text-gray-700 mb-2">Gallery Images</label>
                <input type="file" name="gallery[]" id="gallery" multiple class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                 @error('gallery.*')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Certificates -->
            <div class="mb-6">
                <label for="certificates" class="block text-sm font-medium text-gray-700 mb-2">Certificates</label>
                <input type="file" name="certificates[]" id="certificates" multiple class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                 @error('certificates.*')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Clients -->
            <div class="mb-6">
                <label for="clients" class="block text-sm font-medium text-gray-700 mb-2">Clients</label>
                <input type="file" name="clients[]" id="clients" multiple class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                 @error('clients.*')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end border-t pt-6 mt-6">
                <button type="submit" class="flex items-center gap-2 bg-emerald-500 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-emerald-600 shadow-md transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Create Record
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
