@extends('admin.layout')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Upload Hero Image</h1>

    <form action="{{ route('admin.hero.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Select Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <button class="btn btn-primary">Upload</button>
    </form>
</div>
@endsection
