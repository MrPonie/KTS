<x-user.template_header title="Edit group"/>

<x-alerts/>

<form action="{{ route('groups.edit', request()->id) }}" method="post" id="update-group-form" class="panel flex flex-col gap-4">
    @csrf
    <div class="flex justify-between border-b border-gray-200 pb-4">
        <h1>Editing {{$group->name}}</h1>
        <div class="flex gap-2">
            <x-button type="link" style="secondary" text="Cancel" link="{{ route('groups') }}"/>
            <x-button type="button" style="primary-filled" text="Update" id="update-button"/>
        </div>
    </div>
    <x-inputs.text type="text" name="name" label="Name" value="{{ $group->name }}"/>
    <x-inputs.textarea type="text" name="description" label="Description" value="{{ $group->description }}"/>
</form>

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
            let inputs = $('#update-group-form')[0].elements;
            let nameChanged = inputs['name'].value != '{{ $group->name }}';
            let descriptionChanged = inputs['description'].value != '{{ $group->description }}';
            let usersChanged = false;
            $('#confirm-dialog .changes').html(``
                +(nameChanged ? '<p>&#x2022; Group name will be changed.</p>' : '')
                +(descriptionChanged ? '<p>&#x2022; Description will be changed.</p>' : '')
                +(usersChanged ? '<p>&#x2022; Users list will be updated.</p>' : '')
            );
            $('#confirm-dialog')[0].showModal();
        });
        $('.dialog-cancel-button').on('click', function() {
            $('#confirm-dialog')[0].close();
        });
        $('#dialog-confirm-button').on('click', function() {
            $('#update-group-form').trigger('submit');
        });
    };
</script>