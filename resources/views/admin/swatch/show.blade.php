@extends('admin.layout')

@section('title', 'Swatch Details')

@section('content')
    <div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.swatch.index') }}"
                    class="p-2 rounded-full bg-white text-gray-500 hover:text-purple-600 hover:bg-purple-50 border border-gray-200 transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Swatch Request #{{ $swatch->id }}</h1>
                    <p class="text-sm text-gray-500">Requested on {{ $swatch->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>

            <form action="{{ route('admin.swatch.destroy', $swatch->id) }}" method="POST"
                onsubmit="return confirm('Delete this request?');">
                @csrf @method('DELETE')
                <button type="submit"
                    class="flex items-center gap-2 px-4 py-2 bg-white text-red-600 border border-red-200 rounded-lg hover:bg-red-50 hover:border-red-300 transition-all text-sm font-medium shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete Request
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left Column: Details --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Client & Delivery Info --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Client Details
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Name</label>
                            <p class="text-gray-900 font-medium text-lg">{{ $swatch->name }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Email</label>
                            <p class="text-gray-900 font-medium">{{ $swatch->email }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Phone</label>
                            <p class="text-gray-900 font-medium">{{ $swatch->phone_country }} {{ $swatch->phone_number }}
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Delivery
                                Address</label>
                            <p class="text-gray-900 font-medium bg-gray-50 p-3 rounded-lg border border-gray-100">
                                {{ $swatch->address }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Message Card --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        Client's Message
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-6 text-gray-700 leading-relaxed border border-gray-100">
                        {{ $swatch->message }}
                    </div>
                </div>
            </div>

            {{-- Right Column: Sidebar --}}
            <div class="space-y-6">

                {{-- Status Card --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Request Status</h3>
                    <form action="{{ route('admin.swatch.status', $swatch->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <div class="relative">
                            <select name="status" onchange="this.form.submit()"
                                class="appearance-none w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block p-3 pr-8 font-medium cursor-pointer">
                                <option value="pending" {{ $swatch->status == 'pending' ? 'selected' : '' }}>🟡 Pending
                                </option>
                                <option value="approved" {{ $swatch->status == 'approved' ? 'selected' : '' }}>🟢 Approved
                                </option>
                                <option value="delivered" {{ $swatch->status == 'delivered' ? 'selected' : '' }}>🔵 Delivered
                                </option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Product Info Card --}}
                <div
                    class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg border border-gray-700 p-6 text-white overflow-hidden relative">
                    <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl">
                    </div>

                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Target Product</h3>

                    <div class="mb-4">
                        <p class="text-xs text-gray-400">Product Code</p>
                        <p class="text-2xl font-mono font-bold text-purple-400 tracking-wider">
                            {{ $swatch->product?->product_code ?? 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400">Product Name</p>
                        <p class="font-medium text-gray-100">
                            {{ $swatch->product?->name ?? 'Product Not Found' }}
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection