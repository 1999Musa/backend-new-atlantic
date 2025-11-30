@extends('admin.layout')

@section('content')
<div class="card p-4 shadow">
    <h2 class="mb-4">Edit Hero Image</h2>

    <img src="{{ asset('storage/' . $orderHero->image) }}" width="300" class="rounded mb-3">

    <form action="{{ route('admin.orderhero.update', $orderHero->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Title</label>
        <input type="text" name="title" class="form-control mb-3" value="{{ $orderHero->title }}">

        <label>Replace Image</label>
        <input type="file" name="image" class="form-control mb-3">

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
