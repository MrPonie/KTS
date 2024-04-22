<div class="relative">
    <label @if(!empty($name)) for="{{ $name }}" @endif>{{ $label }}</label>
    @if (!empty($name))
        @error($name)
            <p class="input-error">{{ $message }}</p>
        @enderror
    @endif
    <div class="flex items-center w-full relative">
        <input wire:model.live="search" type="text" class="grow input-text" placeholder="Search...">
        @if (!empty($search))
            <button wire:click="clear" type="button" class="button-error absolute right-0 mr-1"><x-icon icon="x"/></button>
        @endif
    </div>
    <div class="absolute border">
        <p>heh</p>
    </div>
</div>
