<div @if(!empty($id)) id="{{ $id }}" @endif class="input-select-search flex flex-col gap-1 {{ $class }}">
    @isset($label)
        <label @isset($name) for="{{ $name }}" @endisset>{{ $label }}</label>
    @endisset
    <input type="hidden" @isset($name) name="{{ $name }}" id="{{ $name }}" @endisset class="select-search-input">
    <input wire:model.live="search" type="text" class="select-search-search-input input-text w-full">
    <div class="relative">
        <div class="select-search-search-results">
            <ul class="absolute w-full flex flex-col gap-1 border border-gray-200 bg-white rounded">
                @for ($i=0; $i<3; $i++)
                    <li wire:loading.class="opacity-75">
                        <button type="button" class="select-search-option-button w-full p-2 text-start hover:bg-purple-50"><p>{{ $search }}</p></button>
                    </li>
                @endfor
            </ul>
        </div>
    </div>
    @isset($name)
        @error($name)
            <p class="input-error">{{$message}}</p>
        @enderror
    @endisset
</div>