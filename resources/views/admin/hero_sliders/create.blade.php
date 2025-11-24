@extends('admin.layout')

@section('title', 'Create Hero Slide')

@section('content')
<div class="max-w-5xl mx-auto py-10">
    
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">New Hero Slide</h1>
            <p class="text-sm text-gray-500 mt-1">Create a new banner for your homepage.</p>
        </div>
        <a href="{{ route('admin.hero-sliders.index') }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">
            Cancel & Go Back
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        {{-- Decorative top strip --}}
        <div class="h-1 bg-gradient-to-r from-indigo-500 to-purple-600 w-full"></div>

        <form action="{{ route('admin.hero-sliders.store') }}" method="POST" enctype="multipart/form-data" class="p-0">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 h-full">
                
                {{-- Left Side: Image Upload Zone --}}
                <div class="p-8 bg-gray-50 lg:col-span-1 border-r border-gray-100 flex flex-col justify-between">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Banner Image</label>
                        <p class="text-xs text-gray-400 mb-4">Supported: JPG, PNG. (1920x1080 recommended)</p>
                        
                        {{-- Drop/Preview Zone --}}
                        <div class="relative w-full aspect-[4/3] lg:aspect-[3/4] rounded-xl overflow-hidden bg-white border-2 border-dashed border-gray-300 group hover:border-indigo-500 hover:bg-indigo-50/10 transition-all cursor-pointer">
                            
                            {{-- The actual input (invisible covering full area) --}}
                            <input type="file" name="hero_image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" 
                                   required onchange="previewImage(event)">
                            
                            {{-- Placeholder State --}}
                            <div id="upload-placeholder" class="absolute inset-0 flex flex-col items-center justify-center text-center p-4">
                                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <span class="text-sm font-medium text-gray-600 group-hover:text-indigo-600">Click to Upload</span>
                            </div>

                            {{-- Image Preview (Hidden initially) --}}
                            <img id="image-preview" src="#" alt="Preview" class="absolute inset-0 w-full h-full object-cover hidden z-10">
                        </div>
                    </div>
                </div>

                {{-- Right Side: Form Content --}}
                <div class="p-8 lg:col-span-2 flex flex-col justify-center">
                    <div class="space-y-6">
                        
                        {{-- Title Input --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
                            <input type="text" name="title" placeholder="Optional"
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none shadow-sm placeholder-gray-400 text-lg">
                        </div>


                        {{-- Action Buttons --}}
                        <div class="pt-8 flex items-center gap-4">
                            <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-lg shadow-indigo-200 transition-all transform active:scale-95 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Save Slide
                            </button>
                            
                            <a href="{{ route('admin.hero-sliders.index') }}" class="px-6 py-3 text-gray-600 font-medium hover:bg-gray-50 rounded-lg transition-colors">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        const placeholder = document.getElementById('upload-placeholder');
        const preview = document.getElementById('image-preview');

        reader.onload = function(){
            preview.src = reader.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        
        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection