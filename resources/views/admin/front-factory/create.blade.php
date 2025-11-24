@extends('admin.layout')

@section('content')
<div class="container">
    <h1>Add Factory Image</h1>
    <form method="POST" action="{{ route('admin.front-factory.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Title (optional)</label>
            <input type="text" name="title" class="form-control">
        </div>
        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
