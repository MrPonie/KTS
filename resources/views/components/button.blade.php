@if ($type == 'link')
<a href="{{ $link }}" class="{{ $buttonClass, $class }}" @disabled($disabled)>
@else
<button type="{{ $type }}" class="{{ $buttonClass }} {{$class}}" @disabled($disabled)>
@endif

{{ $text }}

@if ($type == 'link')
</a>
@else
</button>
@endif
