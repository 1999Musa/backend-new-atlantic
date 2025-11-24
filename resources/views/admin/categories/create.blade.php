@extends('admin.layout')


@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4">Create Category</h2>

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded shadow">
        @csrf

        <div>
            <label class="block text-sm font-medium">Title</label>
            <input name="title" value="{{ old('title') }}" class="mt-1 block w-full border rounded p-2" />
            @error('title') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Description</label>
            <textarea name="description" class="mt-1 block w-full border rounded p-2">{{ old('description') }}</textarea>
            @error('description') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Hero Image</label>
            <input type="file" name="hero_image" class="mt-1" />
            @error('hero_image') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        <div class="flex gap-3">
            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 border rounded">Cancel</a>
            <button class="px-4 py-2 bg-amber-400 text-white rounded">Create</button>
        </div>
    </form>
</div>
@endsection