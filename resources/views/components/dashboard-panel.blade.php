@props([
    'title' => '',
])

<div class="flex-down p-2 bg-white border border-gray-200 shadow rounded">
    <h2>{{ $title }}</h2>
    <div class="w-full">
        {{ $slot }}
    </div>
</div>