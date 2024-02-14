<section class="sidebar-nav flex flex-col gap-2 p-2 bg-gray-50">
    @php
        $selected = 1;
    @endphp
    @foreach ([0,1,2,3,4] as $i)
        <div class="nav-item">
            <a href="" class="" @selected($i == $selected)>List item {{ $i }}</a>
        </div>
    @endforeach
    
    <!-- nav item -->
    <!-- <a href="" class="grow rounded-lg hover:ring-1 hover:ring-inset hover:ring-purple-200 p-2">link</a> -->
    <!-- nav item selected -->
    <!-- <a href="" class="grow rounded-lg hover:ring-1 hover:ring-inset hover:ring-purple-200 p-2 bg-purple-200" disabled>link selected</a> -->
    <!-- nav item with subitems -->
    <!-- <div class="rounded-lg shadow-inner overflow-hidden bg-gray-100" style="box-shadow: 0px 0px 4px 0px rgba(0,0,0,0.24) inset;">
        <div class="flex bg-gray-50">
            <a href="" class="grow rounded-tl-lg hover:ring-1 hover:ring-inset hover:ring-purple-200 p-2">link dropdown</a>
            <button class="rounded-r-lg hover:ring-1 hover:ring-inset hover:ring-purple-200 px-2">v</button>
        </div>
        <div class="hidden"></div>
    </div> -->
    <!-- nav item with subitems extended -->
    <!-- <div class="rounded-lg shadow-inner overflow-hidden bg-gray-100" style="box-shadow: 0px 0px 4px 0px rgba(0,0,0,0.24) inset;">
        <div class="flex bg-gray-50">
            <a href="" class="grow rounded-tl-lg hover:ring-1 hover:ring-inset hover:ring-purple-200 p-2 
            ring-1 ring-inset ring-purple-200">link dropdown</a>
            <button class="rounded-tr-lg hover:ring-1 hover:ring-inset hover:ring-purple-200 px-2 
            bg-purple-200">^</button>
        </div>
        <div class="flex flex-col">
            <a href="" class="p-1 hover:ring-1 hover:ring-inset hover:ring-purple-200">subitem</a>
            <a href="" class="p-1 hover:ring-1 hover:ring-inset hover:ring-purple-200">subitem</a>
            <a href="" class="p-1 hover:ring-1 hover:ring-inset hover:ring-purple-200">subitem</a>
        </div>
    </div> -->

    <x-navlist :list="[
        ['name'=>'item 1','link'=>'link 1'],
        ['name'=>'item 1','link'=>'link 1','has_sub_items'=>true,'list'=>[
            ['name'=>'subitem 1','link'=>'sublink 1'],
            ['name'=>'subitem 2','link'=>'sublink 2'],
        ]],
        ['name'=>'item 1','link'=>'link 1','has_sub_items'=>true,'list'=>[
            ['name'=>'subitem 1','link'=>'sublink 1'],
            ['name'=>'subitem 2','link'=>'sublink 2','has_sub_items'=>true,'list'=>[
                ['name'=>'subsubitem 1','link'=>'subsublink 1'],
                ['name'=>'subsubitem 2','link'=>'subsublink 2'],
            ]],
        ]],
    ]"/>

</section>