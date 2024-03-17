<div class="flex flex-col gap-1">
    @if (isset($label) && !empty($label))
        <label @isset($name) for="{{ $name }}" @endisset>{{ $label }}</label>
    @endif
    <select @isset($name) id="{{ $name }}" name="{{ $name }}" value="" @endisset class="input-select">
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
