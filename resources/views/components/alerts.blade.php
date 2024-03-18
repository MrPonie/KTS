@if (session('success'))
    <x-alert type="success" message="{{ session('success') }}"/>
@endif
@if (session('error'))
    <x-alert type="error" message="{{ session('error') }}"/>
@endif
@if (session('warning'))
    <x-alert type="success" message="{{ session('warning') }}"/>
@endif