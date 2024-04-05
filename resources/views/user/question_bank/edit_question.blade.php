<x-user.template-header title="Edit question"/>

<x-alerts/>

@if (session('debug'))
    <pre><?php print_r(session('debug'));?></pre>
@endif

<form action="{{ route('question_bank.edit_question', $id) }}" method="post" class="panel flex flex-col gap-2">
    @csrf
    <div class="flex justify-between pb-2 border-b border-gray-200">
        <h1>New Question</h1>
        <div class="flex gap-2">
            <x-button type="link" style="secondary" text="Cancel" link="{{ route('question_bank') }}"/>
            <x-button type="submit" style="primary-filled" text="Update" id="submit-button"/>
        </div>
    </div>
    <livewire:question-builder :edit="true" :showanswer="true" :question="$question"/>
    <livewire:model-list model="Topic" searchcolumn="name" name="topics" label="Topics" :filter="[ ['column'=>'created_by', 'operator'=>'=', 'value'=>Auth::id()] ]" :list="$topics"/>
</form>

<x-user.template-footer/>