<x-user.template-header title="Edit user"/>

<x-alerts/>

<div class="panel">
    <form action="{{ route('users.edit', request()->id) }}" method="post" id="update-user-form" class="flex flex-col gap-4">
        @csrf
        <div class="flex justify-between border-b border-gray-200 pb-4">
            <h1>Editing {{$user->username}}</h1>
            <div class="flex gap-2">
                <x-button type="link" style="secondary" text="Cancel" link="{{ route('users') }}"/>
                <x-button type="submit" style="primary-filled" text="Update"/>
            </div>
        </div>
        <x-inputs.checkbox name="is_active" label="Is active" value="active" checked="{{ $user->is_active }}"/>
        <x-inputs.select name="role" label="Role" :options="$roles" selected="{{ $user->role_id }}"/>
        <x-inputs.text type="password" name="password" label="New Password"/>
        <x-inputs.text type="password" name="retype_password" label="Retype New Password"/>
        <livewire:model-list model="Group" searchcolumn="name" name="groups" label="Groups" :list="$list"/>
    </form>
</div>

<x-user.template-footer/>