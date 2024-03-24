<div class="flex flex-col gap-1 {{ $class }}">
    @if (!empty($label))
        <label @if(!empty($name)) for="{{ $name }}" @endif>{{ $label }}</label>
    @endif
    <textarea @if(!empty($name)) name="{{ $name }}" id="{{ $name }}" @endif class="input-textarea" cols="{{ $cols }}" rows="{{ $rows }}" @readonly($readonly)>{{ old($name) ?: $value }}</textarea>
    @isset($name)
        @error($name)
            <p class="input-error">{{$message}}</p>
        @enderror
    @endisset
</div>