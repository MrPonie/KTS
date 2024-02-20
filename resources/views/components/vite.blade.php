@if (file_exists(public_path('hot')))
    @vite($resource)
@else
    @switch($type)
        @case('css')
            <link rel="stylesheet" href="{{ Vite::asset($resource) }}">
            @break
        @case('js')
            <script src="{{ Vite::asset($resource) }}"></script>
            @break
        @default
            @break
    @endswitch
@endif