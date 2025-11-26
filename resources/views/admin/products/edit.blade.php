@extends('admin.layout')

@section('title', 'Edit Product')

@section('content')
    <div class="max-w-3xl mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Product: {{ $product->name }}</h2>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-4 bg-white p-6 rounded shadow">

            @csrf
            @method('PUT')

            <!-- Category -->
            <div>
                <label class="block text-sm font-medium">Category</label>
                <select name="category_id" class="mt-1 block w-full border rounded p-2">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Product Name -->
            <div>
                <label class="block text-sm font-medium">Product Name</label>
                <input name="name" value="{{ $product->name }}" class="mt-1 block w-full border rounded p-2" />
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium">Description</label>
                <textarea name="description"
                    class="mt-1 block w-full border rounded p-2">{{ $product->description }}</textarea>
            </div>

            <!-- Extra Description -->
            <div>
                <label class="block text-sm font-medium">Extra Description</label>
                <textarea name="extra_description"
                    class="mt-1 block w-full border rounded p-2">{{ $product->extra_description }}</textarea>
            </div>

            <!-- Product Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <label class="block text-sm font-medium">Product Code</label>
                    <input name="product_code" value="{{ $product->product_code }}"
                        class="mt-1 block w-full border rounded p-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium">MOQ</label>
                    <input name="moq" value="{{ $product->moq }}" class="mt-1 block w-full border rounded p-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium">FOB</label>
                    <input name="fob" value="{{ $product->fob }}" class="mt-1 block w-full border rounded p-2" />
                </div>
            </div>

            <!-- Price & Discount -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium">Main Price</label>
                    <input type="number" step="0.01" name="price" value="{{ $product->price }}"
                        class="mt-1 block w-full border rounded p-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium">Discounted Price</label>
                    <input type="number" step="0.01" name="discounted_price" value="{{ $product->discounted_price }}"
                        class="mt-1 block w-full border rounded p-2" />
                </div>
            </div>

<!-- MAIN IMAGES -->
<div>
    <label class="block text-sm font-medium">Main Product Images</label>

    <div id="oldMainImages" class="flex gap-3 flex-wrap mt-2">
        @foreach($product->images as $img)
            <div class="relative w-24 h-24">
                <img src="{{ Storage::url($img->path) }}" 
                     class="w-full h-full object-cover border rounded" />

                <button type="button"
                        class="absolute top-0 right-0 bg-red-600 text-white text-xs px-1 rounded"
                        onclick="removeImage({{ $img->id }}, 'remove_main', event)">
                    ✖
                </button>
            </div>
        @endforeach
    </div>

    <input type="hidden" name="remove_main" id="remove_main">
    <input type="file" name="images[]" multiple class="mt-2" />
</div>

<!-- EXTRA/CUSTOMIZE IMAGES -->
<div>
    <label class="block text-sm font-medium text-blue-700">Customize Page Images</label>

    <div id="oldExtraImages" class="flex gap-3 flex-wrap mt-2">
        @foreach($product->extraImages as $img)
            <div class="relative w-24 h-24">
                <img src="{{ Storage::url($img->path) }}" 
                     class="w-full h-full object-cover border rounded">

                <button type="button"
                        class="absolute top-0 right-0 bg-red-600 text-white text-xs px-1 rounded"
                        onclick="removeImage({{ $img->id }}, 'remove_extra', event)">
                    ✖
                </button>
            </div>
        @endforeach
    </div>

    <input type="hidden" name="remove_extra" id="remove_extra">
    <input type="file" name="extra_images[]" multiple class="mt-2" />
</div>

            <!-- Actions -->
            <div class="flex gap-3 mt-4">
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border rounded">Cancel</a>

                <button class="px-4 py-2 bg-amber-400 text-white rounded">
                    Update
                </button>
            </div>

        </form>
    </div>

    <!-- ====================================================== -->
    <!--                   DELETE IMAGE SCRIPT                  -->
    <!-- ====================================================== -->
   <script>
function removeImage(id, field, event) {
    event = event || window.event;
    event.preventDefault();

    // Get hidden input
    let input = document.getElementById(field);
    let current = input.value ? input.value.split(',') : [];

    // Add removed image ID
    current.push(id);
    input.value = current.join(',');

    // Remove image from DOM
    const box = event.target.closest('.relative');
    if (box) box.remove();
}
</script>




@endsection