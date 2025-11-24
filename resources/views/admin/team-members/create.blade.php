@extends('admin.layout')

@section('title', 'Add Team Member')

@section('content')
<h2 class="text-2xl font-bold mb-6">Add Team Member</h2>

<form action="{{ route('admin.team-members.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
    @csrf

    <div class="mb-4">
        <label class="block font-semibold mb-1">Name</label>
        <input type="text" name="name" class="w-full border p-2 rounded" required>
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1">Position</label>
        <input type="text" name="position" class="w-full border p-2 rounded" required>
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1">Position 2 (Optional)</label>
        <input type="text" name="position2" class="w-full border p-2 rounded">
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1">Description</label>
        <textarea name="description" class="w-full border p-2 rounded" rows="4"></textarea>
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1">Image</label>
        <input type="file" name="image" class="w-full">
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Member</button>
</form>
@endsection
