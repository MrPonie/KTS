<div class="flex flex-col gap-1">
    <label @if(!empty($name)) for="{{ $name }}" @endif>{{ $label }}</label>
    <div class="p-2 border border-gray-200 rounded">
        <input type="file" @if(!empty($name)) name="{{ $name }}" id="{{ $name }}" @endif>
    </div>
    @if(!empty($name))
        @error($name)
            <p class="input-error">{{$message}}</p>
        @enderror
    @endif
</div>