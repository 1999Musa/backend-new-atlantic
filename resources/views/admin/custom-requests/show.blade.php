@extends('admin.layout')

@section('title', 'Request Details')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.custom-requests.index') }}" class="p-2 rounded-full bg-white text-gray-500 hover:text-indigo-600 hover:bg-gray-50 border border-gray-200 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Request #{{ $custom->id }}</h1>
                <p class="text-sm text-gray-500">Received on {{ $custom->created_at->format('M d, Y') }} at {{ $custom->created_at->format('h:i A') }}</p>
            </div>
        </div>
        
        {{-- Single Delete Action --}}
        <button onclick="confirmDelete({{ $custom->id }})" class="flex items-center gap-2 px-4 py-2 bg-white text-red-600 border border-red-200 rounded-lg hover:bg-red-50 hover:border-red-300 transition-all text-sm font-medium shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            Delete Request
        </button>
        <form id="delete-form-{{ $custom->id }}" action="{{ route('admin.custom-requests.destroy', $custom->id) }}" method="POST" class="hidden">
            @csrf @method('DELETE')
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Left Column: Request Details --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Message Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    Client Message
                </h3>
                <div class="bg-gray-50 rounded-lg p-6 text-gray-700 leading-relaxed whitespace-pre-line border border-gray-100">
                    {{ $custom->message }}
                </div>
            </div>

            {{-- Attachment Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Attachment</h3>
                @if($custom->attachment)
                    <div class="flex items-center justify-between p-4 bg-indigo-50 border border-indigo-100 rounded-lg group hover:border-indigo-200 transition-all">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-white rounded-lg text-indigo-600 shadow-sm">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Attachment File</p>
                                <p class="text-xs text-indigo-600">Click download to view</p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/'.$custom->attachment) }}" download class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 shadow-md shadow-indigo-200 transition-all">
                            Download
                        </a>
                    </div>
                @else
                    <div class="text-center py-6 border-2 border-dashed border-gray-200 rounded-lg text-gray-400">
                        No attachment provided
                    </div>
                @endif
            </div>

        </div>

        {{-- Right Column: Sidebar --}}
        <div class="space-y-6">
            
            {{-- Status Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Current Status</h3>
                
                <form action="{{ route('admin.custom-requests.update-status', $custom->id) }}" method="POST">
                    @csrf
                    <div class="relative">
                        <select name="status" onchange="this.form.submit()" 
                            class="appearance-none w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-3 pr-8 font-medium cursor-pointer hover:border-gray-400 transition-colors">
                            <option value="pending" {{ $custom->status == 'pending' ? 'selected' : '' }}>🟡 Pending Processing</option>
                            <option value="approved" {{ $custom->status == 'approved' ? 'selected' : '' }}>🟢 Approved</option>
                            <option value="delivered" {{ $custom->status == 'delivered' ? 'selected' : '' }}>🔵 Delivered</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </form>

                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Quantity Requested:</span>
                        <span class="font-bold text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ $custom->quantity }} Units</span>
                    </div>
                </div>
            </div>

            {{-- Client Info Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Client Information</h3>
                
                <div class="flex items-center gap-4 mb-6">
                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                        {{ substr($custom->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-gray-900 font-bold">{{ $custom->name }}</p>
                        <p class="text-xs text-gray-500">Customer</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-start gap-3 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span class="break-all">{{ $custom->email }}</span>
                    </div>
                    <div class="flex items-start gap-3 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>{{ $custom->phone_country }} {{ $custom->phone_number }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Delete Request?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection