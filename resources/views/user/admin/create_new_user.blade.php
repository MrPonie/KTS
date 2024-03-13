<x-header title="Create new user"/>

<!-- @dump(session('role')) -->

<div class="flex flex-col w-full h-full">
    <div class="w-full">
        <x-user.header/>
    </div>
    <div class="page-container">
        <div class="page-sidebar">
            <x-user.sidebar focusitem="Users" focussubitem="Create new user"/>
        </div>
        <div class="page-content">
            
        </div>
    </div>
</div>

<x-footer/>
