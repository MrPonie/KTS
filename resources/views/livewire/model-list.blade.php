<div class="">
    <label @if(!empty($name)) for="{{ $name }}" @endif>{{ $label }}</label>
    @if (!empty($name))
        @error($name)
            <p class="input-error">{{ $message }}</p>
        @enderror
    @endif
    <div class="flex-down p-2 border border-gray-200 rounded">
        <div class="flex gap-2">
            <div class="flex items-center w-full relative">
                <input wire:model.live="search" type="text" class="grow input-text" placeholder="Search...">
                @if (!empty($search))
                    <button wire:click="clear" type="button" class="button-error absolute right-0 mr-1"><x-icon icon="x"/></button>
                @endif
            </div>
            <button @if ($selected) wire:click="add()" @endif type="button" class="button-primary" @disabled(empty($selected))>Add</button>
        </div>
        @if (!empty($options))
            <div class="flex-down p-2 border border-gray-200 rounded">
                @foreach ($options as $index=>$option)
                    <label><input wire:change="option_checkbox_change({{ $index }}, $event.target.checked)" type="checkbox"> {{ $option->name }}</label>
                @endforeach
            </div>
        @endif
        <div class="flex-down border border-gray-200 rounded">
            @if (empty($list))
                <p class="p-1 text-gray-400">List is empty...</p>
            @endif
            @foreach ($list as $index=>$item)
                <div class="flex gap-2 p-1">
                    <input type="hidden" @if(!empty($name)) name="{{ $name }}[]" @endif value="{{ $item->id }}">
                    <p class="grow">{{ $item->name }}</p>
                    <button wire:click="remove({{ $index }})" type="button" class="button-error"><x-icon icon="trash" style="solid"/></button>
                </div>
            @endforeach
        </div>
    </div>
</div>