<x-user.template-header title="Create new question" sidebarfocusitem="Question Bank" sidebarfocussubitem="Create new question"/>

<x-alerts/>

{{-- @dump(session('debug')) --}}

<form action="{{ route('question_bank.create_question') }}" method="post" class="panel flex flex-col gap-2">
    @csrf
    <div class="flex justify-between pb-2 border-b border-gray-200">
        <h1>New Question</h1>
        <div class="flex gap-2">
            <x-button type="link" style="secondary" text="Cancel" link="{{ route('question_bank') }}"/>
            <x-button type="submit" style="primary-filled" text="Create" id="submit-button"/>
        </div>
    </div>
    <livewire:question-builder/>
    <livewire:model-list model="Topic" searchcolumn="name" name="topics" label="Topics"/>
</form>

<x-user.template-footer/>