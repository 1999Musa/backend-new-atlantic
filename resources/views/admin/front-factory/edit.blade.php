@extends('admin.layout')

@section('content')
<div class="container">
    <h1>Edit Factory Image</h1>
    <form method="POST" action="{{ route('admin.front-factory.update', $frontFactory->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Title (optional)</label>
            <input type="text" name="title" value="{{ $frontFactory->title }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Current Image</label><br>
            <img src="{{ asset('storage/'.$frontFactory->image) }}" width="120" class="mb-2">
            <input type="file" name="image" class="form-control">
        </div>
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
