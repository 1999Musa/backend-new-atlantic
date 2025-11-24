@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')

<!-- Dashboard Header -->
<div class="mb-10">
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h1 class="text-3xl font-bold text-gray-800">
            Welcome back, <span class="text-emerald-600">{{ Auth::user()->name ?? 'Admin' }}</span>!
        </h1>
        <p class="text-gray-500 mt-2">
            Here's a snapshot of your website's content.
            @php
                date_default_timezone_set('Asia/Dhaka');
            @endphp
            Today is {{ date('l, F j, Y') }}.
        </p>
    </div>
</div>

<!-- Stats Cards Grid -->
<h2 class="text-xl font-semibold text-gray-700 mb-4">Overview</h2>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Card Template -->
    @php
        // In your controller, you should pass a $stats variable like this:
        // $stats = [
        //     'team_members' => \App\Models\TeamMember::count(),
        //     'clients' => \App\Models\Client::count(),
        //     'categories' => \App\Models\ProductCategory::count(),
        //     'sliders' => \App\Models\HeroSlider::count(),
        // ];
        // This is a placeholder for demonstration.
        $stats = [
            'team_members' => 8,
            'clients' => 15,
            'categories' => 5,
            'sliders' => 3,
        ];
    @endphp

    <!-- Team Members Card -->
    <div class="bg-white p-5 rounded-lg shadow-md border border-gray-200 flex items-center gap-4 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
        <div class="bg-emerald-100 text-emerald-600 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
        </div>
        <div>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['team_members'] }}</p>
            <p class="text-sm text-gray-500">Team Members</p>
        </div>
    </div>

    <!-- Clients Card -->
    <div class="bg-white p-5 rounded-lg shadow-md border border-gray-200 flex items-center gap-4 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
        <div class="bg-sky-100 text-sky-600 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
        </div>
        <div>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['clients'] }}</p>
            <p class="text-sm text-gray-500">Clients</p>
        </div>
    </div>

    <!-- Product Categories Card -->
    <div class="bg-white p-5 rounded-lg shadow-md border border-gray-200 flex items-center gap-4 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
        <div class="bg-amber-100 text-amber-600 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
        </div>
        <div>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['categories'] }}</p>
            <p class="text-sm text-gray-500">Product Categories</p>
        </div>
    </div>

     <!-- Sliders Card -->
     <div class="bg-white p-5 rounded-lg shadow-md border border-gray-200 flex items-center gap-4 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
        <div class="bg-violet-100 text-violet-600 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" /></svg>
        </div>
        <div>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['sliders'] }}</p>
            <p class="text-sm text-gray-500">Hero Sliders</p>
        </div>
    </div>
</div>

@endsection
