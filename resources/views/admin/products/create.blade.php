@extends('admin.layout')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4">Create Product</h2>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
          class="space-y-4 bg-white p-6 rounded shadow">

        @csrf

        <!-- Category -->
        <div>
            <label class="block text-sm font-medium">Category</label>
            <select name="category_id" class="mt-1 block w-full border rounded p-2">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                @endforeach
            </select>
        </div>

        <!-- Product Name -->
        <div>
            <label class="block text-sm font-medium">Product Name</label>
            <input name="name" class="mt-1 block w-full border rounded p-2" />
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-medium">Description</label>
            <textarea name="description" class="mt-1 block w-full border rounded p-2"></textarea>
        </div>

        <!-- Extra Description -->
        <div>
            <label class="block text-sm font-medium">Extra Description</label>
            <textarea name="extra_description" class="mt-1 block w-full border rounded p-2"></textarea>
        </div>

        <!-- Product Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div>
                <label class="block text-sm font-medium">Product Code</label>
                <input name="product_code" class="mt-1 block w-full border rounded p-2" />
            </div>
            <div>
                <label class="block text-sm font-medium">MOQ</label>
                <input name="moq" class="mt-1 block w-full border rounded p-2" />
            </div>
            <div>
                <label class="block text-sm font-medium">FOB</label>
                <input name="fob" class="mt-1 block w-full border rounded p-2" />
            </div>
        </div>

        <!-- Price & Discount Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium">Main Price</label>
                <input type="number" step="0.01" name="price"
                       class="mt-1 block w-full border rounded p-2" />
            </div>
            <div>
                <label class="block text-sm font-medium">Discounted Price</label>
                <input type="number" step="0.01" name="discounted_price"
                       class="mt-1 block w-full border rounded p-2" />
            </div>
        </div>

        <!-- =========================== -->
        <!-- MAIN IMAGES + LIVE PREVIEW -->
        <!-- =========================== -->
        <div>
            <label class="block text-sm font-medium">Main Product Images</label>

            <!-- Preview -->
            <div id="mainPreview" class="flex gap-2 mt-2 flex-wrap"></div>

            <!-- Upload -->
            <input type="file" name="images[]" multiple class="mt-1"
                   onchange="previewImages(event, 'mainPreview')" />
        </div>

        <!-- =========================== -->
        <!-- CUSTOMIZE IMAGES + PREVIEW -->
        <!-- =========================== -->
        <div>
            <label class="block text-sm font-medium text-blue-700">Customize Page Images</label>

            <!-- Preview -->
            <div id="customPreview" class="flex gap-2 mt-2 flex-wrap"></div>

            <!-- Upload -->
            <input type="file" name="custom_images[]" multiple class="mt-1"
                   onchange="previewImages(event, 'customPreview')" />

            <p class="text-xs text-gray-500">These images will appear only on the CUSTOMIZE page.</p>
        </div>

        <!-- Actions -->
        <div class="flex gap-3">
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border rounded">Cancel</a>
            <button class="px-4 py-2 bg-amber-400 text-white rounded">Create</button>
        </div>

    </form>
</div>

<!-- Live Preview Script -->
<script>
function previewImages(event, previewId) {
    let container = document.getElementById(previewId);
    container.innerHTML = "";

    [...event.target.files].forEach(file => {
        let img = document.createElement("img");
        img.src = URL.createObjectURL(file);
        img.className = "w-20 h-20 object-cover border rounded";
        container.appendChild(img);
    });
}
</script>
@endsection
