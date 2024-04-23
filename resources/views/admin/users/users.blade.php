<x-user.template-header title="Users" sidebarfocusitem="Users"/>

<x-alerts/>

<div class="panel flex-down">
    <div class="w-full flex justify-between">
        <h1>Users</h1>
        <x-button type="link" style="primary-filled" text="Create new User" link="{{ route('users.create') }}"/>
    </div>
    <form action="" method="get" class="flex gap-2">
        <x-inputs.select name="role" label="Role" :options="[null=>'None',1=>'Administrator',2=>'Teacher',3=>'Student']" selected="{{ Request::input('role') }}" class="w-full"/>
        <x-inputs.select name="group" label="Group" :options="$all_groups" selected="{{ Request::input('group') }}" class="w-full"/>
        <x-inputs.select name="by" label="Created by" :options="$admins" selected="{{ Request::input('by') }}" class="w-full"/>
        <x-inputs.select name="active" label="Is active" :options="[null=>'None', true=>'Active', false=>'Inactive']" selected="{{ Request::input('active') }}" class="w-full"/>
        <x-inputs.text type="search" name="search" label="Search" value="{{ Request::input('search') }}"/>
        <x-button type="submit" style="primary-filled" text="Filter"/>
    </form>
</div>

<div class="panel">
    <table class="table">
        <thead>
            <tr>
                <th class="text-start">Username</th>
                <th class="text-start">Role</th>
                <th class="text-start">Groups</th>
                <th class="text-start">Online</th>
                <th class="text-start">Active</th>
                <th class="text-start">Last login</th>
                <th class="text-start">Created by</th>
                <th class="text-start">Created at</th>
                <th class="text-start">Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($users = $users)
                @foreach ($users as $index=>$user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @if ($user_groups = $groups[$index])
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($user_groups as $group)
                                        <span class="bg-gray-200 rounded p-1">{{ $group }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td>
                            @if ($user->is_online)
                                <span class="text-green-500">Online</span>
                            @else
                                <span class="text-red-500">Offline</span>
                            @endif
                        </td>
                        <td>
                            @if ($user->is_active)
                                <span class="text-green-500">Active</span>
                            @else
                                <span class="text-red-500">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $user->last_login_at }}</td>
                        <td>{{ $user->created_by }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            <div class="flex gap-2">
                                @if (session('username') != $user->username)
                                    <x-button type="link" style="primary" leadingIcon="pen-to-square" title="Edit user" link="{{ route('users.edit', $user->id) }}"/>
                                    @if ($user->is_active)
                                        <form action="{{ route('users.deactivate') }}" method="post" onsubmit="return confirm('Do you really want to Deactivate this user?')">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <x-button type="submit" style="error" leadingIcon="ban" leadingIconStyle="solid" title="Deactivate user"/>
                                        </form>
                                    @else
                                        <form action="{{ route('users.activate') }}" method="post" onsubmit="return confirm('Do you really want to Activate this user?')">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <x-button type="submit" style="success" leadingIcon="circle" title="Activate user"/>
                                        </form>
                                    @endif
                                @endif
                            </div> 
                        </td>
                    </tr>
                @endforeach                            
            @endif
        </tbody>
    </table>
</div>

<x-user.template-footer/>