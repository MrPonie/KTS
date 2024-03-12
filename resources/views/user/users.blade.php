@if (session('role'))
@else
    <?php 
    header('Location: '.URL::to('/user'));
    exit;
    ?>
@endif

<x-header title="Users"/>

@dump(session('role'))

<div class="flex flex-col w-full h-full">
    <div class="w-full">
        <x-user.header/>
    </div>
    <div class="page-container">
        <div class="page-sidebar">
            <x-user.sidebar focusitem="Users" focussubitem="All users"/>
        </div>
        <div class="page-content">
            all users page content
        </div>
    </div>
</div>

<x-footer/>
