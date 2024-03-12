<header class="w-full flex justify-between bg-white">
    <div class="flex items-center">
        <h1>KITTY</h1>
        @if (session('role'))
             <h1 class="ml-2 pl-2 border-l border-gray-200 capitalize">{{ session('role')['name'] }}</h1>
        @endif
    </div>
    <div class="flex gap-2 p-2">
        <x-user.user_button/>
        <x-button style="primary" text="MM" class="md:hidden"/>
    </div>
</header>