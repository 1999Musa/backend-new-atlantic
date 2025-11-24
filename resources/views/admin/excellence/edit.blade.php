@extends('admin.layout')

@section('title', 'Edit Excellence Section')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.excellence.index') }}" class="flex items-center gap-2 bg-gray-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-600 shadow-md transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Excellence Sections
        </a>
    </div>

    <div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">
            Edit Section: <span class="text-emerald-600">{{ $section->title }}</span>
        </h2>

        <form action="{{ route('admin.excellence.update', $section->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Current Images -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Images</label>
                <p class="text-xs text-gray-500 mb-4">Click "Remove" to delete an image immediately.</p>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="image-gallery">
                    @forelse($section->images ?? [] as $img)
                        <div class="relative group image-item" data-img="{{ $img }}">
                            <img src="{{ asset('storage/'.$img) }}" class="w-full h-32 object-cover rounded-lg shadow-sm" alt="Image">
                            <button 
                                type="button"
                                class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full hover:bg-red-600 transition delete-btn"
                                data-img="{{ $img }}">
                                Remove
                            </button>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm col-span-full">No images in this section yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Upload New Images -->
            <div class="mb-6">
                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Upload New Images</label>
                <input type="file" name="images[]" id="images" multiple
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full 
                    file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 
                    file:text-emerald-700 hover:file:bg-emerald-100">
            </div>

            <div class="flex justify-end border-t pt-6 mt-6">
                <button type="submit" class="flex items-center gap-2 bg-emerald-500 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-emerald-600 shadow-md transition-all">
                    Update Section
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ✅ AJAX delete -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".delete-btn");

    buttons.forEach((btn) => {
        btn.addEventListener("click", async function () {
            if (!confirm("Are you sure you want to remove this image?")) return;

            const imagePath = this.dataset.img;
            const sectionId = "{{ $section->id }}";
            const token = "{{ csrf_token() }}";

            try {
                const response = await fetch(`/admin/excellence/${sectionId}/remove-image`, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({ image: imagePath })
                });

                const result = await response.json();

                if (result.success) {
                    this.closest(".image-item").remove();
                    alert("Image removed successfully!");
                } else {
                    alert(result.message || "Failed to remove image.");
                }
            } catch (error) {
                console.error("Error:", error);
                alert("Something went wrong while deleting the image.");
            }
        });
    });
});
</script>
@endsection
