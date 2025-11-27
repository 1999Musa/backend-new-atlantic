    @extends('admin.layout')

    @section('title', 'Custom Requests')

    @section('content')
    <div class="max-w-7xl mx-auto py-10">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Custom Requests</h1>
                <p class="text-sm text-gray-500 mt-1">Manage and track product customization inquiries.</p>
            </div>

            {{-- Bulk Action Bar (Hidden by default) --}}
            <div id="bulk-actions" class="hidden items-center gap-3 animate-fade-in-up">
                <span class="text-sm text-gray-600 font-medium bg-gray-100 px-3 py-1 rounded-full">
                    <span id="selected-count">0</span> Selected
                </span>
                <button onclick="executeBulkDelete()" 
                        class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 shadow-lg shadow-red-200 transition-all transform active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Delete Selected
                </button>
            </div>
        </div>

        {{-- Main Table Card --}}
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            
            @if($requests->isEmpty())
                {{-- Empty State --}}
                <div class="text-center py-20">
                    <div class="bg-indigo-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No Requests Found</h3>
                    <p class="text-gray-500 mt-1">Wait for customers to submit customization forms.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                                <th class="p-5 w-10">
                                    <input type="checkbox" id="select-all" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                                </th>
                                <th class="p-5">Client Details</th>
                                <th class="p-5">Product Info</th>
                                <th class="p-5">Status</th>
                                <th class="p-5">Attachment</th>
                                <th class="p-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($requests as $req)
                                <tr class="hover:bg-gray-50/80 transition-colors group">
                                    <td class="p-5">
                                        <input type="checkbox" class="record-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer" value="{{ $req->id }}">
                                    </td>
                                    
                                    {{-- Client Column --}}
                                    <td class="p-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-md">
                                                {{ substr($req->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900">{{ $req->name }}</div>
                                                <div class="text-xs text-gray-500">ID: #{{ $req->id }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Product Column --}}
                                    <td class="p-5">
                                        <div class="text-sm font-medium text-gray-800">
                                            Product ID: <span class="text-indigo-600">{{ $req->product?->product_code }}</span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-0.5">
                                            Qty: <span class="font-semibold text-gray-700 bg-gray-100 px-1.5 py-0.5 rounded">{{ $req->quantity }}</span>
                                        </div>
                                    </td>

                                    {{-- Status Dropdown Column --}}
                                    <td class="p-5">
                                        <form action="{{ route('admin.custom-requests.update-status', $req->id) }}" method="POST">
                                            @csrf
                                            <select name="status" onchange="this.form.submit()" 
                                                    class="text-xs font-bold uppercase tracking-wide py-1.5 pl-3 pr-8 rounded-full border-0 cursor-pointer focus:ring-2 focus:ring-offset-1 transition-all
                                                    {{ $req->status == 'pending' ? 'bg-yellow-100 text-yellow-700 focus:ring-yellow-400' : '' }}
                                                    {{ $req->status == 'approved' ? 'bg-green-100 text-green-700 focus:ring-green-400' : '' }}
                                                    {{ $req->status == 'delivered' ? 'bg-blue-100 text-blue-700 focus:ring-blue-400' : '' }}">
                                                <option value="pending" {{ $req->status=='pending'?'selected':'' }}>🟡 Pending</option>
                                                <option value="approved" {{ $req->status=='approved'?'selected':'' }}>🟢 Approved</option>
                                                <option value="delivered" {{ $req->status=='delivered'?'selected':'' }}>🔵 Delivered</option>
                                            </select>
                                        </form>
                                    </td>

                                    {{-- Attachment Column --}}
                                    <td class="p-5">
                                        @if($req->attachment)
                                            <a href="{{ asset('storage/'.$req->attachment) }}" download 
                                            class="inline-flex items-center gap-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded-lg hover:bg-indigo-100 transition-colors border border-indigo-100">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4 4m4-4v12"></path></svg>
                                                Download
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-400 italic flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                No File
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Actions Column --}}
                                    <td class="p-5 text-right">
                                        <div class="flex items-center justify-end gap-2 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity duration-200">
                                            {{-- View Button --}}
                                            <a href="{{ route('admin.custom-requests.show', $req->id) }}" 
                                            class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="View Details">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>

                                            {{-- Delete Button --}}
                                            <form action="{{ route('admin.custom-requests.destroy', $req->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this request?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination Footer --}}
                <div class="p-5 border-t border-gray-100 bg-gray-50/50">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Hidden Form for Bulk Delete --}}
    <form id="bulk-delete-form" action="{{ route('admin.custom-requests.bulk-delete') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="ids" id="bulk-delete-ids">
    </form>

    {{-- Modern Javascript for Bulk Actions --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.record-checkbox');
            const bulkActions = document.getElementById('bulk-actions');
            const selectedCount = document.getElementById('selected-count');

            function updateBulkState() {
                const checkedBoxes = document.querySelectorAll('.record-checkbox:checked');
                selectedCount.innerText = checkedBoxes.length;

                if (checkedBoxes.length > 0) {
                    bulkActions.classList.remove('hidden');
                    bulkActions.classList.add('flex');
                } else {
                    bulkActions.classList.add('hidden');
                    bulkActions.classList.remove('flex');
                }
            }

            if(selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                    updateBulkState();
                });
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateBulkState);
            });
        });

        function executeBulkDelete() {
            const selected = Array.from(document.querySelectorAll('.record-checkbox:checked')).map(cb => cb.value);
            if (selected.length === 0) return;

            if (confirm(`Are you sure you want to permanently delete ${selected.length} requests?`)) {
                document.getElementById('bulk-delete-ids').value = selected.join(',');
                document.getElementById('bulk-delete-form').submit();
            }
        }
    </script>

    {{-- Custom Animation Style --}}
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.3s ease-out forwards;
        }
    </style>
    @endsection