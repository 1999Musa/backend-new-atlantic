@extends('admin.layout')

@section('title', 'Product Categories')

@section('content')

<!-- Header -->
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        Product Categories
    </h1>
    <div class="flex items-center gap-4">
        <!-- See All Products Button -->
        <a href="{{ route('admin.products.index') }}"
           class="flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-emerald-600 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
            </svg>
            See All Products
        </a>
        
        <!-- Add New Category Button -->
        <a href="{{ route('admin.categories.create') }}"
           class="flex items-center gap-2 py-2 px-4 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add New Category
        </a>
    </div>
</div>

<!-- Session Message -->
@if (session('success'))
    <div class="mb-6 p-4 bg-emerald-100 text-emerald-800 border border-emerald-200 rounded-lg shadow-sm" role="alert">
        {{ session('success') }}
    </div>
@endif

<!-- Category Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($categories as $cat)
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden flex flex-col transition-all duration-300 hover:shadow-lg">

            <!-- Content Section -->
            <div class="p-5 flex-1 flex flex-col">
                <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $cat->title }}</h3>
                <p class="text-sm text-gray-600 mb-4 flex-1">{{ Str::limit($cat->description, 120) }}</p>

                <!-- Actions Section -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <!-- Edit Button -->
                        <a href="{{ route('admin.categories.edit', $cat) }}"
                           class="flex items-center gap-1 py-1 px-3 bg-yellow-500 text-white rounded-lg text-xs font-medium hover:bg-yellow-600 transition-colors shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                        <!-- Delete Button -->
                        <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="flex items-center gap-1 py-1 px-3 bg-red-600 text-white rounded-lg text-xs font-medium hover:bg-red-700 transition-colors shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                    
                    <!-- Add Product Link -->
                    <a href="{{ route('admin.products.create') }}?category_id={{ $cat->id }}"
                       class="flex items-center gap-1 text-sm text-emerald-600 hover:text-emerald-700 font-medium transition-colors">
                        + Add Product
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="mt-8">
    {{ $categories->links() }}
</div>

@endsection
