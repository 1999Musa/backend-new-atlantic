@extends('admin.layout')

@section('content')
<div class="container">
    <h2 class="mb-4">Place Order Items</h2>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.place-order.create') }}" class="btn btn-primary mb-3">+ Add Item</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th><th>Type</th><th>Step</th><th>Title</th><th>Description</th><th>List Items</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ ucfirst($item->type) }}</td>
                <td>{{ $item->step }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->description }}</td>
                <td>
                    @if($item->list_items)
                        <ul>
                        @foreach($item->list_items as $li)
                            <li>{{ $li }}</li>
                        @endforeach
                        </ul>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.place-order.edit',$item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.place-order.destroy',$item->id) }}" method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete this?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
