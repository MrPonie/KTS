<x-user.template_header title="Groups" sidebarfocusitem="Users" sidebarfocussubitem="Groups"/>

<x-alerts/>

<div class="panel">
    <div class="w-full flex justify-between">
        <h1>Groups</h1>
        <x-button type="link" style="primary-filled" text="Create new Group" link="{{ route('groups.create') }}"/>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th class="text-start">Name</th>
                <th class="text-start">Description</th>
                <th class="text-start">User count</th>
                <th class="text-start">Created by</th>
                <th class="text-start">Created at</th>
                <th class="text-start">Action</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($groups))
                @foreach ($groups as $group)
                    <tr>
                        <td>{{ $group->name }}</td>
                        <td>{{ $group->description }}</td>
                        <td>{{ $group->user_count }}</td>
                        <td>{{ $group->created_by }}</td>
                        <td>{{ $group->created_at }}</td>
                        <td>
                            <div class="flex gap-2">
                                <x-button type="link" style="primary" leadingIcon="pen-to-square" title="Edit group" link="{{ route('groups.edit', $group->id) }}"/>
                            </div>
                        </td>
                    </tr>
                @endforeach                            
            @endif
        </tbody>
    </table>
</div>

<x-user.template_footer/>