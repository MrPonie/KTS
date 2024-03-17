<div class="flex flex-col gap-1">
    <label @isset($name) for="{{ $name }}" @endisset class="flex gap-1">
        <input type="checkbox" @isset($name) name="{{ $name }}" id="{{ $name }}" @endisset value="{{ $value }}" @checked($checked)>
        @isset($label) {{ $label }} @endisset
    </label>
    @isset($name)
        @error($name)
            <p class="input-error">{{$message}}</p>
        @enderror
    @endisset
</div>