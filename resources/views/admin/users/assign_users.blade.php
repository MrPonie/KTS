<x-user.template-header title="Assign users"/>

<x-alerts/>

<form action="{{ route('users.assign', Request::input('id')) }}" method="post" class="panel flex-down">
    <div class="flex justify-between items-center">
        <h1>Assign student groups to ...</h1>
        <div class="flex gap-1">
            <x-button type="button" style="secondary" text="Cancel"/>
            <x-button type="submit" style="primary-filled" text="Assign"/>
        </div>
    </div>
    <livewire:model-list model="Group" searchcolumn="name" name="groups" label="User groups"/>
</form>

<x-user.template-footer/>