@if ($type == 'link')
<a href="{{ $link }}" {{ $attributes->class(['ja pierdole', $buttonClass]) }} @disabled($disabled) >
@else
<button type="{{ $type }}" {{ $attributes->class(['ja pierdole', $buttonClass]) }} @disabled($disabled) >
@endif
@if (!empty($leadingIcon))
    <span><x-icon icon="{{ $leadingIcon }}" style="{{ $leadingIconStyle }}"/>@if($text) &nbsp; @endif</span>
@endif
{{ $text }}
@if (!empty($trailingIcon))
    <span>{{ $text ? '&nbsp;' : ''}}<x-icon icon="{{ $trailingIcon }}" style="{{ $trailingIconStyle }}"/></span>
@endif
@if ($type == 'link')
</a>
@else
</button>
@endif
