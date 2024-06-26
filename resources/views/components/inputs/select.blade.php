<div {{ $attributes->class(['flex flex-col gap-1']) }} >
    @if (!empty($label))
        <label @isset($name) for="{{ $name }}" @endisset>{{ $label }}</label>
    @endif
    <select @if(!empty($name)) id="{{ $name }}" name="{{ $name }}" value="" @endif class="input-select">
        <option value hidden>Select</option>
        @foreach ($options as $value=>$name)
            <option value="{{ $value }}" @selected($selected == $value)>{{ $name }}</option>
        @endforeach
    </select>
    @isset($name)
        @error($name)
            <p class="input-error">{{$message}}</p>
        @enderror
    @endisset
</div>
