<x-user.template-header title="Edit group"/>

<x-alerts/>

<form action="{{ route('groups.edit', request()->id) }}" method="post" id="update-group-form" class="panel flex flex-col gap-4">
    @csrf
    <div class="flex justify-between border-b border-gray-200 pb-4">
        <h1>Editing {{$group->name}}</h1>
        <div class="flex gap-2">
            <x-button type="link" style="secondary" text="Cancel" link="{{ route('groups') }}"/>
            <x-button type="submit" style="primary-filled" text="Update"/>
        </div>
    </div>
    <x-inputs.text type="text" name="name" label="Name" value="{{ $group->name }}"/>
    <x-inputs.textarea type="text" name="description" label="Description" value="{{ $group->description }}"/>
    <livewire:model-list model="User" searchcolumn="username" :filter="[['column'=>'is_active','operator'=>'=','value'=>1]]" name="users" label="Users" :list="$list"/>
</form>

<x-user.template-footer/>