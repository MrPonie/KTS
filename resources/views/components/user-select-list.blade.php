<div class="user-select-list" data-users="{{ json_encode([1,2,3,4,5,6]) }}">
    <input type="hidden" class="user-select-list-input" value="">
    <div class="flex gap-2">
        <div class="grow"><livewire:user-select-search label="Users"/></div>
        <x-button style="primary-filled" text="Add" class="user-select-search-add-button my-1" disabled/>
    </div>
    <ul class="user-select-list-list border border-gray-200 rounded">
        <p class="user-select-list-empty-notice px-2 py-1">There are no users added...</p>
    </ul>
</div>