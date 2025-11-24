@extends('admin.layout')

@section('title', 'Update Logo')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Brand Settings</h1>
            <p class="text-sm text-gray-500 mt-1">Update your organization's logo and branding.</p>
        </div>
        <a href="{{ route('admin.logo.index') }}" class="text-sm text-gray-500 hover:text-gray-900 flex items-center gap-1 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Dashboard
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <form action="{{ route('admin.logo.update', $logo->id) }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
            @csrf 
            @method('PUT')

            {{-- Current Logo Section --}}
            @if($logo->image)
                <div class="mb-8" id="current-logo-container">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Current Logo</label>
                    <div class="flex items-start gap-6">
                        {{-- Checkerboard background to show transparency --}}
                        <div class="relative p-4 bg-gray-100 rounded-lg border border-gray-200 w-fit">
                            <div class="absolute inset-0 opacity-50 pointer-events-none rounded-lg" 
                                 style="background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 10px 10px;">
                            </div>
                            <img src="{{ Storage::url($logo->image) }}" alt="Current Logo" class="relative z-10 h-20 w-auto object-contain">
                        </div>

                        <div class="flex-1">
                             <button type="button" 
                                     onclick="removeLogo({{ $logo->id }}, this)"
                                     class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-700 text-sm font-medium rounded-lg hover:bg-red-100 border border-transparent hover:border-red-200 transition-all group">
                                <svg class="w-4 h-4 text-red-500 group-hover:text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Remove Logo
                            </button>
                            <p class="text-xs text-gray-500 mt-2">
                                Removing this will revert to the default system text.
                            </p>
                        </div>
                    </div>
                    <hr class="mt-8 border-gray-100">
                </div>
            @endif

            {{-- Upload New Logo Section --}}
            <div class="space-y-4">
                <label class="block text-sm font-medium text-gray-700">Upload New Logo</label>
                
                <div class="relative group">
                    <input type="file" name="image" id="file-upload" class="peer absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                           onchange="previewFileName(this)">
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-xl px-6 py-10 flex flex-col items-center justify-center transition-all peer-hover:border-blue-500 peer-hover:bg-blue-50">
                        <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mb-3 peer-hover:bg-blue-100 transition-colors">
                            <svg class="w-6 h-6 text-gray-400 peer-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        </div>
                        <p class="text-sm text-gray-600 font-medium">
                            <span class="text-blue-600 hover:underline">Click to upload</span> or drag and drop
                        </p>
                        <p class="text-xs text-gray-400 mt-1">PNG, JPG, SVG (Max. 2MB)</p>
                        
                        {{-- Placeholder for selected filename --}}
                        <p id="file-name" class="text-sm text-emerald-600 font-semibold mt-4 hidden flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span id="file-name-text"></span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Footer Actions --}}
            <div class="mt-8 flex items-center justify-end gap-3">
                <a href="{{ route('admin.logo.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm shadow-blue-200 transition-all">
                    <span>Save Changes</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Show selected filename
    function previewFileName(input) {
        const fileNameDisplay = document.getElementById('file-name');
        const fileNameText = document.getElementById('file-name-text');
        
        if (input.files && input.files[0]) {
            fileNameText.textContent = input.files[0].name;
            fileNameDisplay.classList.remove('hidden');
            fileNameDisplay.classList.add('flex');
        } else {
            fileNameDisplay.classList.add('hidden');
        }
    }

    // Remove logo logic
    function removeLogo(id, btn) {
        if(!confirm('Are you sure you want to remove the current logo? This cannot be undone.')) return;

        // Add loading state
        const originalText = btn.innerHTML;
        btn.innerHTML = `<svg class="animate-spin h-4 w-4 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Removing...`;
        btn.disabled = true;

        fetch(`/admin/logo/${id}/remove-image`, {
            method: 'DELETE',
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            if(res.success) {
                // Smoothly fade out the container
                const container = document.getElementById('current-logo-container');
                container.style.transition = "all 0.5s";
                container.style.opacity = "0";
                setTimeout(() => container.remove(), 500);
            } else {
                alert('Something went wrong.');
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error removing logo.');
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }
</script>
@endsection