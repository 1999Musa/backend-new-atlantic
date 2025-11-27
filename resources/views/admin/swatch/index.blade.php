@extends('admin.layout')

@section('content')
<h1 class="text-2xl font-bold mb-4">Swatch Requests</h1>

<table class="table-auto w-full border">
    <thead>
        <tr class="bg-gray-100">
            <th class="px-4 py-2">Product Code</th>
            <th class="px-4 py-2">Product Name</th>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Phone</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($swatches as $s)
        <tr class="border-t">
            <td class="px-4 py-2">{{ $s->product_code }}</td>
            <td class="px-4 py-2">{{ $s->product->name ?? 'N/A' }}</td>
            <td class="px-4 py-2">{{ $s->name }}</td>
            <td class="px-4 py-2">{{ $s->email }}</td>
            <td class="px-4 py-2">{{ $s->phone_country }} {{ $s->phone_number }}</td>
            <td class="px-4 py-2">
                <form method="POST" action="{{ route('admin.swatch.status', $s) }}">
                    @csrf
                    @method('PATCH')
                    <select name="status" onchange="this.form.submit()">
                        <option value="pending" @selected($s->status=='pending')>Pending</option>
                        <option value="approved" @selected($s->status=='approved')>Approved</option>
                        <option value="delivered" @selected($s->status=='delivered')>Delivered</option>
                    </select>
                </form>
            </td>
            <td class="px-4 py-2">{{ $s->created_at->format('d M Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $swatches->links() }}
@endsection
