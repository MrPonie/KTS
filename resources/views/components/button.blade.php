@if ($type == 'link')
<a href="{{ $link }}" @isset($id) {{ $id }} @endisset class="{{ $buttonClass, $class }}" @disabled($disabled) title="{{ $title }}">
@else
<button type="{{ $type }}" @isset($id) id="{{ $id }}" @endisset class="{{ $buttonClass }} {{$class}}" @disabled($disabled) title="{{ $title }}">
@endif

<span><x-icon icon="{{ $leadingIcon }}" style="{{ empty($leadingIconStyle) ? 'regular' : $leadingIconStyle }}"/></span>{{ $text }}<span><x-icon icon="{{ $trailingIcon }}" style="{{ empty($trailingIconStyle) ? 'regular' : $trailingIconStyle }}"/></span>

@if ($type == 'link')
</a>
@else
</button>
@endif
