<x-user.template-header title="Edit Test Form"/>

<x-alerts/>

<form action="{{ route('test_form_vault.create') }}" method="post" class="panel flex-down">
    @csrf
    <div class="flex justify-between pb-2 border-b border-gray-200">
        <h1>Editing {{ $form->name }}</h1>
        <div class="flex gap-2">
            <x-button type="link" style="secondary" text="Cancel" link="{{ route('test_form_vault') }}"/>
            <x-button type="submit" style="primary-filled" text="Update" id="submit-button"/>
        </div>
    </div>
    <x-inputs.text name="title" label="Title" value="{{ $form->name }}"/>
    <x-inputs.textarea name="description" label="Description" value="{{ $form->description }}"/>
    <h2>Questions</h2>
    <livewire:test-form-builder :formID="1"/>
</form>

<x-user.template-footer/>