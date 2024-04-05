<x-user.template-header title="Edit topic"/>

<x-alerts/>

<form action="{{ route('question_bank.edit_topic', request()->id) }}" method="post" class="panel">
    @csrf
    <div class="flex justify-between pb-2 border-b border-gray-200 mb-2">
        <h1>New Topic</h1>
        <div class="flex gap-2">
            <x-button type="link" style="secondary" text="Cancel" link="{{ route('question_bank.topics') }}"/>
            <x-button type="submit" style="primary-filled" text="Update" id="submit-button"/>
        </div>
    </div>
    <div class="flex-down">
        <x-inputs.text name="name" label="Name" value="{{ $topic->name }}"/>
        <x-inputs.textarea name="description" label="Description" value="{{ $topic->description }}"/>
    </div>
</form>

<x-user.template-footer/>