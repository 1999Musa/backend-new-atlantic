@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Add Place Order Item</h2>
    <form method="POST" action="{{ route('admin.place-order.store') }}">
        @csrf
        <div class="form-group">
            <label>Type</label>
            <select name="type" class="form-control" required>
                <option value="step">Step</option>
                <option value="info">Important Info</option>
                <option value="reason">Reason</option>
            </select>
        </div>
        <div class="form-group">
            <label>Step No (Only for Steps)</label>
            <input type="text" name="step" class="form-control">
        </div>
        <div class="form-group">
            <label>Title (Required)</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Description (Optional)</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label>List Items (Optional, one per line)</label>
            <textarea name="list_items[]" class="form-control" placeholder="Enter items here..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Save</button>
    </form>
</div>
@endsection
