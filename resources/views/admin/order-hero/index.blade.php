@extends('admin.layout')

@section('content')
<div class="card p-4 shadow">
    <h2 class="mb-4">Order Hero Image</h2>

    @if($hero)
        <img src="{{ asset('storage/' . $hero->image) }}" width="300" class="rounded mb-3">
        <br>
        <a href="{{ route('admin.orderhero.edit', $hero->id) }}" class="btn btn-primary">Edit</a>
    @else
        <a href="{{ route('admin.orderhero.create') }}" class="btn btn-success">Add Hero Image</a>
    @endif
</div>
@endsection
