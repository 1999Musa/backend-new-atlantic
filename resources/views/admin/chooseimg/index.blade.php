@extends('admin.layout')

@section('title', 'Choose Section Hero Image')

@section('content')
<div class="container mx-auto">

    @if($image)
        <!-- Image Preview Card -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Current Hero Image</h3>
            <div class="mb-6">
                <img src="{{ asset('storage/' . $image->image) }}" alt="Hero Image" class="max-w-xl mx-auto rounded-lg shadow-lg">
            </div>
            <div class="flex justify-center">
                <a href="{{ route('admin.chooseimg.edit', $image->id) }}" class="flex items-center gap-2 bg-indigo-500 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-600 shadow-md transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Image
                </a>
            </div>
        </div>
    @else
        <!-- Upload Prompt Card -->
        <div class="bg-white rounded-lg shadow-md p-10 text-center">
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No Hero Image Found</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Get started by uploading an image for this section.
                </p>
                <div class="mt-6">
                     <a href="{{ route('admin.chooseimg.create') }}" class="flex items-center justify-center gap-2 w-full max-w-xs mx-auto bg-emerald-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-emerald-600 shadow-md transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Upload Hero Image
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
