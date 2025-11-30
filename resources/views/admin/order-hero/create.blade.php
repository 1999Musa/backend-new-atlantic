@extends('admin.layout')

@section('content')
<div class="card p-4 shadow">
    <h2 class="mb-4">Add Hero Image</h2>

    <form action="{{ route('admin.orderhero.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Title</label>
        <input type="text" name="title" class="form-control mb-3">

        <label>Image (1920x600 recommended)</label>
        <input type="file" name="image" class="form-control mb-3" required>

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
