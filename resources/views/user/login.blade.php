<x-header title="User Login"/>

<div class="relative w-full h-screen">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex flex-col gap-3 p-4 rounded-lg bg-white shadow min-w-[400px]">
        <h1 class="text-center"><div class="inline-block w-6 h-6 bg-gray-700"></div>Login</h1>
        <form action="{{ route('user.login') }}" method="post">
            @csrf
            <div class="flex flex-col gap-6">
                <x-inputs.text type="hidden" name="top" label=""/>
                <x-inputs.text type="text" name="username" label="Username"/>
                <x-inputs.text type="password" name="password" label="Password"/>
                <div class="flex">
                    <x-button type="submit" text="Login" class="grow justify-center"/>
                </div>
            </div>
        </form>
    </div>
</div>