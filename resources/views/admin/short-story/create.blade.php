@extends('admin.layout')

@section('content')
<div class="container">
    <h1>Add Short Story Video</h1>
    <form method="POST" action="{{ route('admin.short-story.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control">
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Video</label>
            <input type="file" name="video" class="form-control">
        </div>
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
