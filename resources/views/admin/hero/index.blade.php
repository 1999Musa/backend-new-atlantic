@extends('admin.layout')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Hero Section</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($hero && $hero->image)
        <div class="mb-4">
            <img src="{{ asset('storage/' . $hero->image) }}" class="w-64 rounded shadow">
        </div>

        <a href="{{ route('admin.hero.edit', $hero->id) }}" class="btn btn-primary">Edit</a>

        <form action="{{ route('admin.hero.destroy', $hero->id) }}" method="POST" class="inline-block ml-2">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    @else
        <a href="{{ route('admin.hero.create') }}" class="btn btn-success">Upload Hero Image</a>
    @endif
</div>
@endsection
