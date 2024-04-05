<x-user.template-header title="Create new user" sidebarfocusitem="Users" sidebarfocussubitem="Create new user"/>

<x-alerts/>
<form action="{{ route('users.create') }}" method="post" class="panel flex flex-col gap-4">
    @csrf
    <div class="flex justify-between border-b border-gray-200 pb-4">
        <h1>New User</h1>
        <div class="flex gap-2">
            <x-button type="link" style="secondary" text="Cancel" link="{{ route('users') }}"/>
            <x-button type="submit" style="primary-filled" text="Create"/>
        </div>
    </div>
    <x-inputs.text type="text" label="Username" name="username"/>
    <x-inputs.text type="password" label="Password" name="password"/>
    <x-inputs.text type="password" label="Retype password" name="retype_password"/>
    <x-inputs.select label="Role" name="role" :options="$roles"/>
    <x-inputs.checkbox name="is_active" label="Is acttive" value="active"/>
    <livewire:model-list model="Group" searchcolumn="name" name="groups" label="Groups"/>
</form>

<x-user.template-footer/>