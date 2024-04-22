<x-user.template-header title="Create new test form" sidebarfocusitem="Test Form Vault" sidebarfocussubitem="Create new test form"/>

<x-alerts/>

<form action="{{ route('test_form_vault.create') }}" method="post" class="panel flex-down">
    @csrf
    <div class="flex justify-between pb-2 border-b border-gray-200">
        <h1>New Test Form</h1>
        <div class="flex gap-2">
            <x-button type="link" style="secondary" text="Cancel" link="{{ route('question_bank') }}"/>
            <x-button type="submit" style="primary-filled" text="Create" id="submit-button"/>
        </div>
    </div>
    <x-inputs.text name="title" label="Title"/>
    <x-inputs.textarea name="description" label="Description"/>
    <h2>Questions</h2>
    <livewire:test-form-builder/>
</form>

<x-user.template-footer/>