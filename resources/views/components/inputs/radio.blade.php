<label>
    <input type="radio" @if(!empty($name)) name="{{ $name }}" id="{{ $name }}" @endif>
    {{ $label }}
</label>