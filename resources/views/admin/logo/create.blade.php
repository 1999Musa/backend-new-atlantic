@extends('admin.layout')

@section('title', 'Upload Logo')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    
    {{-- Page Header --}}
    <div class="mb-6 text-center md:text-left">
        <h1 class="text-3xl font-bold text-gray-900">Upload Brand Identity</h1>
        <p class="text-gray-500 mt-2">Upload your organization's official logo to be displayed across the platform.</p>
    </div>

    {{-- Main Card --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        
        {{-- Progress / Decorative Top Bar --}}
        <div class="h-2 bg-gradient-to-r from-blue-500 to-indigo-600 w-full"></div>

        <form action="{{ route('admin.logo.store') }}" method="POST" enctype="multipart/form-data" class="p-8 md:p-10">
            @csrf

            {{-- Upload Zone --}}
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Logo File</label>
                
                <div class="relative w-full group">
                    {{-- The actual hidden input --}}
                    <input type="file" name="image" id="logo-upload" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" 
                           required onchange="handleFileSelect(this)">
                    
                    {{-- The Visual Interface --}}
                    <div id="drop-zone" class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 transition-all duration-300 group-hover:border-indigo-500 group-hover:bg-indigo-50/30">
                        
                        {{-- Default State Icons --}}
                        <div id="default-view" class="flex flex-col items-center text-center transition-opacity duration-300">
                            <div class="p-4 bg-white rounded-full shadow-sm mb-4">
                                <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                            </div>
                            <p class="text-lg font-medium text-gray-700">Click to upload or drag and drop</p>
                            <p class="text-sm text-gray-500 mt-1">SVG, PNG, JPG (Max 2MB)</p>
                        </div>

                        {{-- File Selected State (Hidden by default) --}}
                        <div id="file-view" class="hidden flex-col items-center text-center animate-fade-in">
                            <div class="p-3 bg-emerald-100 rounded-full mb-3">
                                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-gray-900 font-semibold" id="file-name-display">filename.png</p>
                            <p class="text-xs text-emerald-600 font-medium mt-1">Ready to upload</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Guidelines Info --}}
            <div class="bg-blue-50 rounded-lg p-4 mb-8 flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="text-sm text-blue-800">
                    <span class="font-semibold">Tip:</span> For the best results on the dashboard, use a PNG image with a transparent background. Recommended size: 200x60px.
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                <a href="{{ url()->previous() }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-8 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-100 shadow-lg shadow-indigo-200 transition-all transform active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Upload Logo
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function handleFileSelect(input) {
        const defaultView = document.getElementById('default-view');
        const fileView = document.getElementById('file-view');
        const fileNameDisplay = document.getElementById('file-name-display');
        const dropZone = document.getElementById('drop-zone');

        if (input.files && input.files[0]) {
            // Update file name
            fileNameDisplay.textContent = input.files[0].name;
            
            // Toggle visibility
            defaultView.classList.add('hidden');
            fileView.classList.remove('hidden');
            fileView.classList.add('flex');

            // Add success border style
            dropZone.classList.remove('border-gray-300', 'border-dashed');
            dropZone.classList.add('border-emerald-400', 'border-solid', 'bg-emerald-50/30');
        }
    }
</script>

<style>
    /* Simple fade animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }
</style>
@endsection