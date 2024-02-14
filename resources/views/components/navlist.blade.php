<div>
    <?php var_dump($list);?>
    @foreach ($list as &$item)
        @if (is_array($item))
            <x-navlist_item :item="$item"/>
        @endif
    @endforeach
</div>