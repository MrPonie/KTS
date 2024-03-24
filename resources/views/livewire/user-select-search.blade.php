@php
    $user_select_seach_id = 'user-select-search'.bin2hex(random_bytes(3));
@endphp
<div id="{{ $user_select_seach_id }}" class="input-select-search flex flex-col gap-1 {{ $class }}">
    @isset($label)
        <label @isset($name) for="{{ $name }}" @endisset>{{ $label }}</label>
    @endisset
    <input type="hidden" @isset($name) name="{{ $name }}" id="{{ $name }}" @endisset class="select-search-input" value="">
    <div class="w-full relative">
        <input wire:model.live="search" type="text" class="select-search-search-input input-text w-full">
        <div class="absolute h-full top-0 right-2 flex items-center"><x-loading-circle/></div>
    </div>
    <div class="relative">
        <div class="select-search-search-results @if (!$users || $users->isEmpty()) hidden @endif">
            <ul class="absolute w-full flex flex-col gap-1 border border-gray-200 bg-white rounded">
                @if ($users)
                    @foreach ($users as $user)
                        <li wire:loading.class="opacity-75">
                            <button type="button" class="select-search-option-button" data-option-value="{{ $user->id }}"><p>{{ $user->username }}</p></button>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
    @isset($name)
        @error($name)
            <p class="input-error">{{$message}}</p>
        @enderror
    @endisset
</div>