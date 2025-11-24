@extends('admin.layout')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Edit Hero Image</h1>

    <img src="{{ asset('storage/' . $hero->image) }}" class="w-64 mb-3 rounded shadow">

    <form action="{{ route('admin.hero.update', $hero->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Replace Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
