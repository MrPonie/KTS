<x-user.template-header title="Question bank" sidebarfocusitem="Question Bank"/>

<x-alerts/>

<div class="panel flex-down">
    <div class="w-full flex justify-between">
        <h1>Questions</h1>
        <x-button type="link" style="primary-filled" text="New Question" link="{{ route('question_bank.create_question') }}"/>
    </div>
    <form action="" method="get" class="w-full flex gap-2">
        <x-inputs.select name="type" class="w-full" :options="$types" :selected="$filter_type"/>
        <x-inputs.select name="topic" class="w-full" :options="$topics" :selected="$filter_topic"/>
        <x-inputs.text class="basis-full" name="search" value="{{ Request::input('search') }}"/>
        <x-button type="submit" style="primary-filled" text="Filter"/>
    </form>
</div>

<div class="panel flex-down">
    <table class="table">
        <thead>
            <tr>
                <th>Question</th>
                <th>Type</th>
                <th>Evaluable</th>
                <th>Points</th>
                <th>Topics</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $index=>$question)
                <tr>
                    <td>{{ $question->question }}</td>
                    <td>
                        @switch($question->type)
                            @case(0) Single select @break
                            @case(1) Multi-select @break
                            @case(2) Text area @break
                            @default Unknown
                        @endswitch
                    </td>
                    <td>{{ $question->evaluable ? 'Yes' : 'No' }}</td>
                    <td>{{ $question->points }}</td>
                    <td>
                        <div class="flex flex-wrap gap-1">
                            @if (!$question_topics[$index]->isEmpty())
                                @foreach ($question_topics[$index] as $topic)
                                    <span class="bg-gray-200 rounded p-1">{{ $topic->name }}</span>
                                @endforeach                    
                            @else
                                <span class="bg-gray-200 rounded p-1">None</span>
                            @endif
                        </div>                        
                    </td>
                    <td>{{ $question->created_at }}</td>
                    <td>{{ $question->updated_at }}</td>
                    <td>
                        <div class="flex gap-1">
                            <x-button type="link" link="{{ route('question_bank.edit_question', $question->id) }}" style="primary" leadingIcon="pen-to-square"/>
                            <form action="{{ route('question_bank.delete_question') }}" method="post" onsubmit="if(!confirm('Permanently delete the question?')){return false;}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $question->id }}">
                                <x-button type="submit" style="error" leadingIcon="x"/>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<x-user.template-footer/>
