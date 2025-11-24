@extends('admin.layout')

@section('content')
    <div class="container">
        <h2>Edit Place Order Entry</h2>
        <form action="{{ route('admin.place-order.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Type (step / info / reason)</label>
                <select name="type" class="form-control" required>
                    <option value="step" {{ $item->type == 'step' ? 'selected' : '' }}>Step</option>
                    <option value="info" {{ $item->type == 'info' ? 'selected' : '' }}>Info</option>
                    <option value="reason" {{ $item->type == 'reason' ? 'selected' : '' }}>Reason</option>
                </select>
            </div>

            <div class="form-group">
                <label>Title (Required)</label>
                <input type="text" name="title" class="form-control" value="{{ $item->title }}" required>
            </div>

            <div class="form-group">
                <label>Description (Optional)</label>
                <textarea name="description" class="form-control">{{ $item->description }}</textarea>
            </div>

            <div class="form-group">
                <label>List Items (Optional, one per line)</label>
                <textarea name="list_items"
                    class="form-control">{{ old('list_items', is_array($item->list_items) ? implode("\n", $item->list_items) : $item->list_items) }}</textarea>
            </div>


            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
@endsection