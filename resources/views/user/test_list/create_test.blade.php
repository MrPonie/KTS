<x-user.template-header title="Create test" sidebarfocusitem="Test List" sidebarfocussubitem="Create new test"/>

<x-alerts/>

<form action="{{ route('test_list.create') }}" method="post" class="panel flex-down">
    @csrf
    <div class="flex justify-between items-center">
        <h1>Creating a test</h1>
        <div class="flex gap-2">
            <x-button type="link" style="secondary" text="Cancel" link="{{ route('test_list') }}"/>
            <x-button type="submit" style="primary-filled" text="Submit"/>
        </div>
    </div>
    <livewire:test-builder/>
    <livewire:model-list model="Group" searchcolumn="name" name="groups" label="Assign to groups"/>
    <livewire:model-list model="User" searchcolumn="username" name="users" label="Assign to select users" :filter="[['column'=>'role_id', 'operator'=>'=', 'value'=>3]]"/>
    <livewire:grading-list/>
</form>

<x-user.template-footer/>