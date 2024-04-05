@if ($type == 'link')
<a href="{{ $link }}" @isset($id) {{ $id }} @endisset class="{{ $buttonClass, $class }}" @disabled($disabled) title="{{ $title }}">
@else
<button type="{{ $type }}" @isset($id) id="{{ $id }}" @endisset class="{{ $buttonClass }} {{$class}}" @disabled($disabled) title="{{ $title }}">
@endif
@if (!empty($leadingIcon))
    <span><x-icon icon="{{ $leadingIcon }}" style="{{ $leadingIconStyle }}"/>{{ $text ? '&nbsp;' : ''}}</span>
@endif
{{ $text }}
@if (!empty($trailingIcon))
    <span>&nbsp;<x-icon icon="{{ $trailingIcon }}" style="{{ $trailingIconStyle }}"/></span>
@endif
@if ($type == 'link')
</a>
@else
</button>
@endif
