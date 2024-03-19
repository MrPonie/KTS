<x-header title="{{ $title }}"/>

<div class="flex flex-col w-full h-full">
    <div class="w-full">
        <x-user.header/>
    </div>
    <div class="page-container">
        <div class="page-sidebar">
            @php
                $focusitem = isset($sidebarfocusitem) ? $sidebarfocusitem : '';
                $focussubitem = isset($sidebarfocussubitem) ? $sidebarfocussubitem : '';
            @endphp
            <x-user.sidebar focusitem="{{ $focusitem }}" focussubitem="{{ $focussubitem }}"/>
        </div>
        <div class="page-content">