<div class="flex flex-col gap-1">
    @if (isset($label) && !empty($label))
        <label @isset($name) for="{{ $name }}" @endisset>{{ $label }}</label>
    @endif
    <input type="{{ $type ?? 'text' }}" @isset($name) id="{{ $name }}" name="{{ $name }}" value="{{ old($name) }}" @endisset class="input-text">
    @isset($name)
        @error($name)
            <p class="input-error">{{$message}}</p>
        @enderror
    @endisset
</div>
