@push('scripts')
    <x-vite type="js" resource="resources/js/components/navlist.js"/>
@endpush
@dump($focusitem)
@dump($focussubitem)

<div class="flex flex-col">
    @foreach ($list as $item)
        <!-- @dump($item) -->
        <div class="navlist-item-container {{ $focusitem == Arr::get($item, 'name') && !empty($focussubitem) ? 'expanded' : '' }}">
            <div class="flex w-full">
                <a href="{{ Arr::get($item, 'link') }}" class="navlist-item {{ $focusitem == Arr::get($item, 'name') && empty($focussubitem) ? 'active' : '' }}">{{ Arr::get($item, 'name') }}</a>
                @if (!empty(Arr::get($item, 'sublist')))
                    <button type="button" class="navlist-sublist-trigger {{ $focusitem == Arr::get($item, 'name') && !empty($focussubitem) ? 'active' : '' }}">
                        <span class="navlist-sublist-trigger-down-icon"><x-icon icon="chevron-down" style="solid"/></span>
                        <span class="navlist-sublist-trigger-up-icon"><x-icon icon="chevron-up" style="solid"/></span>
                    </button>
                @endif
            </div>
            @if ($sublist = Arr::get($item, 'sublist'))
                <div class="navlist-item-sublist flex flex-col">
                        @foreach ($sublist as $subitem)
                            <button type="button" class="navlist-subitem {{ $focussubitem == Arr::get($subitem, 'name') ? 'active' : '' }}">{{ Arr::get($subitem, 'name') }}</button>
                        @endforeach
                </div>
            @endif
        </div>
    @endforeach
</div>