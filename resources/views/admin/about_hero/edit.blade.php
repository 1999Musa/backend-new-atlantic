@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h2>Edit Hero</h2>

    <form action="{{ route('admin.about-hero.update', $aboutHero->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ $aboutHero->title }}">
        </div>
        <div class="mb-3">
            <label>Subtitle</label>
            <input type="text" name="subtitle" class="form-control" value="{{ $aboutHero->subtitle }}">
        </div>
        <div class="mb-3">
            <label>Current Image</label><br>
            @if ($aboutHero->image)
                <img src="{{ asset('storage/'.$aboutHero->image) }}" width="120">
            @endif
            <input type="file" name="image" class="form-control mt-2">
        </div>
        <div class="mb-3">
            <label>Current Video</label><br>
            @if ($aboutHero->video)
                <video width="180" controls>
                    <source src="{{ asset('storage/'.$aboutHero->video) }}" type="video/mp4">
                </video>
            @endif
            <input type="file" name="video" class="form-control mt-2">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
