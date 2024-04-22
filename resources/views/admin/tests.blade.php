<x-user.template-header title="Test list" sidebarfocusitem="Test List"/>

<x-alerts/>

<div class="panel flex-down">
    <div class="flex justify-between items-center">
        <h1>Test List</h1>
        <x-button type="link" style="primary-filled" text="Create new" link="{{ route('') }}"/>
    </div>
</div>

<x-user.template-footer/>