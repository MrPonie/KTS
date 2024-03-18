<x-user.template_header title="Users" sidebarfocusitem="Users"/>

<x-alerts/>

<div class="panel">
    <div class="w-full flex justify-between">
        <h1>Users</h1>
        <x-button type="link" style="primary-filled" text="Create new User" link="{{ route('users.create') }}"/>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th class="text-start">Username</th>
                <th class="text-start">Role</th>
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
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->name }}</td>
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
                        <td>{{ date('Y-m-d', $user->last_login_at) }}</td>
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

<x-user.template_footer/>