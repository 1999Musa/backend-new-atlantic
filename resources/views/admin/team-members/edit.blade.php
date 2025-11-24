@extends('admin.layout')

@section('title', 'Edit Team Member')

@section('content')
<h2 class="text-2xl font-bold mb-6">Edit Team Member</h2>

<form action="{{ route('admin.team-members.update', $teamMember->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block font-semibold mb-1">Name</label>
        <input type="text" name="name" value="{{ $teamMember->name }}" class="w-full border p-2 rounded" required>
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1">Position</label>
        <input type="text" name="position" value="{{ $teamMember->position }}" class="w-full border p-2 rounded" required>
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1">Position 2 (Optional)</label>
        <input type="text" name="position2" value="{{ $teamMember->position2 }}" class="w-full border p-2 rounded">
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1">Description</label>
        <textarea name="description" class="w-full border p-2 rounded" rows="4">{{ $teamMember->description }}</textarea>
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1">Current Image</label>
        @if($teamMember->image)
            <img src="{{ asset('storage/'.$teamMember->image) }}" class="w-32 mb-2">
        @endif
        <input type="file" name="image" class="w-full">
    </div>

    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update Member</button>
</form>
@endsection
