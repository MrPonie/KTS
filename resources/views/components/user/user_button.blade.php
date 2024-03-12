@push('scripts')
    <x-vite type="js" resource="resources/js/components/user_button.js"/>
@endpush
<?php $rnd = bin2hex(random_bytes(3)); ?>
<div class="user-button-container">
    <button class="user-button">
        <div class="w-6 h-6 bg-gray-500"></div>
        @if (session('username'))
            <p>{{ session('username') }}</p>
        @endif
    </button>
    <div class="user-button-popup hidden">
        <div class="flex flex-col gap-2">
            <x-button type="link" link="{{ route('user.profile') }}" text="Profile"/>
            <x-button type="link" link="{{ route('user.logout') }}" text="Logout"/>
        </div>
    </div>
</div>