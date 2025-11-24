@extends('admin.layout')

@section('title', 'Edit Factory')

@section('content')

<!-- Header -->
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        Edit Factory Record
    </h1>
    <a href="{{ route('admin.factory.index') }}" class="flex items-center gap-2 text-sm text-gray-600 hover:text-emerald-600 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Factory Records
    </a>
</div>

<!-- Form Card -->
<div class="bg-white rounded-lg shadow-md border border-gray-200">
    <form action="{{ route('admin.factory.update', $factory->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="p-6 md:p-8">
            <div class="space-y-8">

                <!-- Hero Image Section -->
                <div>
                    <label for="hero_image" class="block text-sm font-semibold text-gray-700 mb-2">
                        Hero Image
                    </label>
                    <!-- Current Image Preview -->
                    @if($factory->hero_image && file_exists(public_path('storage/' . $factory->hero_image)))
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $factory->hero_image) }}" alt="Hero Image" class="w-64 h-auto rounded-lg shadow-sm border border-gray-200">
                        </div>
                    @else
                        <div class="mb-4 text-sm text-gray-500">No hero image uploaded.</div>
                    @endif
                    <!-- File Input -->
                    <input type="file"
                           id="hero_image"
                           name="hero_image"
                           class="w-full max-w-lg text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-colors cursor-pointer">
                </div>

                <!-- Gallery Section -->
                <div class="border-t border-gray-200 pt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-4">
                        Gallery Images
                    </label>
                    <!-- Current Images Preview -->
                    @if($factory->gallery && is_array($factory->gallery) && count($factory->gallery))
                        <div class="mb-4 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4">
                            @foreach($factory->gallery as $idx => $img)
                                @if($img && file_exists(public_path('storage/' . $img)))
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $img) }}" alt="Gallery Image" class="w-full h-28 object-cover rounded-lg shadow-sm border border-gray-200">
                                        <div class="absolute top-1 right-1">
                                            <label class="flex items-center space-x-1 bg-white/70 backdrop-blur-sm border border-gray-200 rounded-full px-2 py-0.5 text-xs text-red-600 cursor-pointer hover:bg-red-500 hover:text-white transition-colors">
                                                <input type="checkbox" name="remove_gallery[]" value="{{ $idx }}" class="h-3 w-3 text-red-600 border-gray-300 rounded-sm focus:ring-red-500">
                                                <span>Remove</span>
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="mb-4 text-sm text-gray-500">No gallery images uploaded.</div>
                    @endif
                    <!-- File Input -->
                    <input type="file"
                           name="gallery[]"
                           multiple
                           class="w-full max-w-lg text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-colors cursor-pointer">
                </div>

                <!-- Certificates Section -->
                <div class="border-t border-gray-200 pt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-4">
                        Certificates
                    </label>
                    <!-- Current Images Preview -->
                    @if($factory->certificates && is_array($factory->certificates) && count($factory->certificates))
                        <div class="mb-4 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4">
                            @foreach($factory->certificates as $idx => $img)
                                @if($img && file_exists(public_path('storage/' . $img)))
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $img) }}" alt="Certificate" class="w-full h-28 object-cover rounded-lg shadow-sm border border-gray-200">
                                        <div class="absolute top-1 right-1">
                                            <label class="flex items-center space-x-1 bg-white/70 backdrop-blur-sm border border-gray-200 rounded-full px-2 py-0.5 text-xs text-red-600 cursor-pointer hover:bg-red-500 hover:text-white transition-colors">
                                                <input type="checkbox" name="remove_certificates[]" value="{{ $idx }}" class="h-3 w-3 text-red-600 border-gray-300 rounded-sm focus:ring-red-500">
                                                <span>Remove</span>
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="mb-4 text-sm text-gray-500">No certificates uploaded.</div>
                    @endif
                    <!-- File Input -->
                    <input type="file"
                           name="certificates[]"
                           multiple
                           class="w-full max-w-lg text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-colors cursor-pointer">
                </div>

                <!-- Clients Section -->
                <div class="border-t border-gray-200 pt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-4">
                        Clients
                    </label>
                    <!-- Current Images Preview -->
                    @if($factory->clients && is_array($factory->clients) && count($factory->clients))
                        <div class="mb-4 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4">
                            @foreach($factory->clients as $idx => $img)
                                @if($img && file_exists(public_path('storage/' . $img)))
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $img) }}" alt="Client Logo" class="w-full h-28 object-cover rounded-lg shadow-sm border border-gray-200">
                                        <div class="absolute top-1 right-1">
                                            <label class="flex items-center space-x-1 bg-white/70 backdrop-blur-sm border border-gray-200 rounded-full px-2 py-0.5 text-xs text-red-600 cursor-pointer hover:bg-red-500 hover:text-white transition-colors">
                                                <input type="checkbox" name="remove_clients[]" value="{{ $idx }}" class="h-3 w-3 text-red-600 border-gray-300 rounded-sm focus:ring-red-500">
                                                <span>Remove</span>
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="mb-4 text-sm text-gray-500">No client images uploaded.</div>
                    @endif
                    <!-- File Input -->
                    <input type="file"
                           name="clients[]"
                           multiple
                           class="w-full max-w-lg text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-colors cursor-pointer">
                </div>

            </div>
        </div>

        <!-- Form Footer -->
        <div class="bg-gray-50 px-6 py-4 rounded-b-lg border-t border-gray-200">
            <div class="flex justify-end items-center gap-4">
                <a href="{{ route('admin.factory.index') }}"
                   class="py-2 px-4 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="flex items-center gap-2 py-2 px-4 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Update Factory
                </button>
            </div>
        </div>
    </form>
</div>
@endsection