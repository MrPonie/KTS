<x-user.template-header title="Profile"/>

<div class="flex flex-col gap-4">
    <!-- User -->
    <div class="panel">
        <div class="flex gap-2 items-center">
            <div class="w-8 h-8 bg-gray-500 rounded"></div>
            <h2>{{ session('username') }}</h2>
            <h3 class="bg-gray-200 text-center rounded px-1">{{ session('role')['name'] }}</h3>
            <div class="ml-auto">
                <x-button type="link" text="Logout" link="{{ route('user.logout') }}"/>
            </div>
        </div>
    </div>
    <div class="w-full flex gap-4">
        <!-- User picture change -->
        <div class="basis-full h-fit panel flex flex-col gap-2">
            <div class="flex gap-2">
                <div class="w-24 h-24 bg-gray-500 rounded"></div>
                <form action="update-user-picture" method="post" class="flex flex-col justify-between">
                    <input type="file" name="" id="">
                    <div class="flex">
                        <x-button type="submit" text="Update"/>
                    </div>
                </form>
            </div>
        </div>
        <!-- User password change -->
        <div class="basis-full h-fit panel flex flex-col gap-2">
            <div class="border border-yellow-500 bg-yellow-100 text-yellow-900 rounded p-2">
                Once changed the user will be signed out
            </div>
            <h2>Change password</h2>
            <form action="" method="post" class="flex flex-col gap-2">
                <x-inputs.text type="password" name="current_password" label="Current Password"/>
                <x-inputs.text type="password" name="new_password" label="New Password"/>
                <x-inputs.text type="password" name="retype_password" label="Retype Password"/>
                <x-button type="submit" text="Change Password"/>
            </form>
        </div>
    </div>
</div>

<x-user.template-footer/>