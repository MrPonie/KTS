<div {{ $attributes->class(['flex flex-col gap-1']) }} >
    @if (isset($label) && !empty($label))
        <label @if(!empty($name)) for="{{ $name }}" @endif>{{ $label }}</label>
    @endif
    <input type="{{ $type ?: 'text' }}" @if(!empty($name)) id="{{ $name }}" name="{{ $name }}" value="{{ old($name) ?: $value }}" @endif min="0" @if($type=='number') value="{{ old($name) ?: $value ?: 0 }}" @endif class="input-text" @disabled($disabled)/>
    @isset($name)
        @error($name)
            <p class="input-error">{{$message}}</p>
        @enderror
    @endisset
</div>
