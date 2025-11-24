@extends('admin.layout')

@section('title', 'Edit Certified Logo')

@section('content')
<div class="container mx-auto">
    <!-- Header with Back Button -->
    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.certified-logos.index') }}" class="flex items-center gap-2 bg-gray-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-600 shadow-md transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Logos
        </a>
    </div>

    <!-- Edit Certified Logo Form -->
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">Edit Certified Logo</h2>

        <form method="POST" action="{{ route('admin.certified-logos.update', $certifiedLogo->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title (Optional)</label>
                <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition" placeholder="Enter logo title" value="{{ old('title', $certifiedLogo->title) }}">
            </div>

            <!-- Image -->
            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                <div class="flex items-center gap-6">
                    <img src="{{ asset('storage/'.$certifiedLogo->image) }}" class="w-24 h-24 object-contain rounded-lg border p-2 bg-gray-50">
                    <input type="file" name="image" id="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>
                 <p class="text-xs text-gray-500 mt-2">Upload a new image to replace the current one.</p>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end border-t pt-6 mt-6">
                <button type="submit" class="flex items-center gap-2 bg-emerald-500 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-emerald-600 shadow-md transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                    </svg>
                    Update Logo
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
