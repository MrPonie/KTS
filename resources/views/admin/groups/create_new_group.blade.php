<x-user.template_header title="Create new group" sidebarfocusitem="Users" sidebarfocussubitem="Create new group"/>

<x-alerts/>
<div class="panel">
    <form action="{{ route('groups.create') }}" method="post" class="flex flex-col gap-4">
        @csrf
        <div class="flex justify-between border-b border-gray-200 pb-4">
            <h1>New Group</h1>
            <div class="flex gap-2">
                <x-button type="link" style="secondary" text="Cancel" link="{{ route('groups') }}"/>
                <x-button type="submit" style="primary-filled" text="Create"/>
            </div>
        </div>
        <x-inputs.text type="text" label="Name" name="name"/>
        <x-inputs.textarea label="Description" name="description"/>
    </form>
</div>

<x-user.template_footer/>