@extends('admin.layout')

@section('content')
<div class="container">
    <h1>Edit Short Story Video</h1>
<form method="POST" action="{{ route('admin.short-story.update', $shortStoryVideo->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" value="{{ $shortStoryVideo->title }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ $shortStoryVideo->description }}</textarea>
    </div>

    <div class="mb-3">
        <label>Video</label><br>
        @if($shortStoryVideo->video)
            <video src="{{ asset('storage/'.$shortStoryVideo->video) }}" width="200" controls class="mb-2"></video>
        @endif
        <input type="file" name="video" class="form-control">
    </div>

    <button class="btn btn-primary">Update</button>
</form>

</div>
@endsection
