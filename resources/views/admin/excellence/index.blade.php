@extends('admin.layout')

@section('title', 'Excellence Sections')

@section('content')
<div class="container mx-auto">
    <!-- Header with a general "Add New Section" button if applicable -->
    <!-- For this structure, adding images is per-section, so a global add button might not be needed unless you want to add a whole new 'excellence' section type -->
    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.excellence.create') }}" class="flex items-center gap-2 bg-emerald-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-emerald-600 shadow-md transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add New Excellence Section
        </a>
    </div>

    <!-- Excellence Sections Grid -->
    <div class="space-y-8">
        @forelse($sections as $section)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-xl font-bold text-gray-800 capitalize">{{ $section->title }}</h2>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.excellence.edit', $section->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 hover:bg-indigo-200 px-3 py-1 rounded-full text-xs font-semibold transition">Edit Section</a>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-4">
                    @foreach($section->images as $img)
                        <div>
                            <img src="{{ asset('storage/' . $img) }}" class="w-full h-32 object-cover rounded-lg shadow-sm" alt="Excellence Image">
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-200 pt-4">
                     <a href="{{ route('admin.excellence.create') }}?section_id={{ $section->id }}" class="flex items-center justify-center gap-2 w-full max-w-xs mx-auto bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-200 shadow-sm transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Upload More Images
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-10 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No Excellence Sections Found</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Get started by adding a new section.
                </p>
                <div class="mt-6">
                     <a href="{{ route('admin.excellence.create') }}" class="flex items-center justify-center gap-2 w-full max-w-xs mx-auto bg-emerald-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-emerald-600 shadow-md transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add New Section
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
