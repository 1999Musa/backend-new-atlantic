@props(['route', 'label'])

<a href="{{ route($route) }}"
    class="flex items-center gap-3 px-3 py-2 rounded-md text-sm transition-all duration-200
        {{ request()->routeIs($route . '*') ? 'bg-emerald-500 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
    <span>{{ $label }}</span>
</a>
