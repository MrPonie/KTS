<div class="flex flex-col gap-1">
    @if (isset($label) && !empty($label))
        <label @isset($name) for="{{ $name }}" @endisset>{{ $label }}</label>
    @endif
    <textarea @isset($name) name="{{ $name }}" @endisset @isset($id) id="{{ $id }}" @endisset class="input-textarea {{ $class }}" cols="{{ $cols }}" rows="{{ $rows }}">{{ old($name) ?: $value }}</textarea>
    @isset($name)
        @error($name)
            <p class="input-error">{{$message}}</p>
        @enderror
    @endisset
</div>