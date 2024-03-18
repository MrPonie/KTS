<x-user.template_header title="Edit user"/>

<x-alerts/>

<div class="panel">
    <form action="{{ route('users.edit', request()->id) }}" method="post" id="update-user-form" class="flex flex-col gap-4">
        @csrf
        <div class="flex justify-between border-b border-gray-200 pb-4">
            <h1>Editing {{$user->username}}</h1>
            <div class="flex gap-2">
                <x-button type="link" style="secondary" text="Cancel" link="{{ route('users') }}"/>
                <x-button type="button" style="primary-filled" text="Update" id="update-button"/>
            </div>
        </div>
        <x-inputs.checkbox name="is_active" label="Is active" value="active" checked="{{ $user->is_active }}"/>
        <x-inputs.select name="role" label="Role" :options="$roles" selected="{{ $user->role_id }}"/>
        <x-inputs.text type="password" name="password" label="New Password"/>
        <x-inputs.text type="password" name="retype_password" label="Retype New Password"/>
    </form>
</div>

<dialog id="confirm-dialog" class="border border-gray-200 bg-white shadow rounded-lg w-1/2 p-2">
    <div class="flex justify-between items-center">
        <h1>Make these changes?</h1>
        <x-button type="button" style="secondary" leadingIcon="x" class="dialog-cancel-button"/>
    </div>
    <div class="my-2 border-b border-gray-200"></div>
    <div class="changes flex flex-col gap-2">
    </div>
    <div class="my-2 border-b border-gray-200"></div>
    <div class="flex justify-between">
        <x-button type="button" style="secondary" text="Cancel" class="dialog-cancel-button"/>
        <x-button type="button" style="primary" text="Confirm" id="dialog-confirm-button"/>
    </div>
</dialog>

<x-user.template_footer/>

<script>
    window.onload = function() {
        $('#update-button').on('click', function() {
            let inputs = $('#update-user-form')[0].elements;
            let activeChanged = inputs['is_active'].checked != {{ $user->is_active ? 'true' : 'false' }};
            let roleChanged = inputs['role'].value != {{ $user->role_id }};
            let passwordChanged = inputs['password'].value ? true : false;
            $('#confirm-dialog .changes').html(``
            +(activeChanged ? '<p>&#x2022; User will be <span class="text-red-500">'+(inputs['is_active'].checked ? 'activated' : 'deactivated')+'</span>.</p>' : '')
            +(roleChanged ? '<p>&#x2022; User role will be changed to <b>'+inputs['role'].options[inputs['role'].value].text+'</b>. <span class="text-red-500">Warning</span> user funcionality will be affected depending on selected role.</p>' : '')
            +(passwordChanged ? '<p>&#x2022; User password will be changed.</p>' : '')
            +(!activeChanged && !roleChanged && !passwordChanged ? 'No Changes were made.' : '')
            );
            $('#confirm-dialog')[0].showModal();
        });
        $('.dialog-cancel-button').on('click', function() {
            $('#confirm-dialog')[0].close();
        });
        $('#dialog-confirm-button').on('click', function() {
            $('#update-user-form').trigger('submit');
        });
    };
</script>