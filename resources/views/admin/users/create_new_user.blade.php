<x-header title="Create new user"/>

<div class="flex flex-col w-full h-full">
    <div class="w-full">
        <x-user.header/>
    </div>
    <div class="page-container">
        <div class="page-sidebar">
            <x-user.sidebar focusitem="Users" focussubitem="Create new user"/>
        </div>
        <div class="page-content">
            <div class="panel flex flex-col gap-4">
                @if (session('success'))
                    <x-alert type="success" message="{{ session('success') }}"/>
                @endif
                @if (session('error'))
                    <x-alert type="error" message="{{ session('error') }}"/>
                @endif
                <form action="{{ route('users.create_new_user') }}" method="post" class="flex flex-col gap-4">
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
                </form>
            </div>
        </div>
    </div>
</div>

<x-footer/>
