<x-user.template-header title="Question bank" sidebarfocusitem="Question Bank"/>

<x-alerts/>

<div class="panel">
    <div class="w-full flex justify-between">
        <h1>Questions</h1>
        <x-button type="link" style="primary-filled" text="New Question" link="{{ route('question_bank.create_question') }}"/>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Question</th>
                <th>Type</th>
                <th>Topics</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $index=>$question)
                <tr>
                    <td>{{ $question->body_json }}</td>
                    <td>
                        @switch(0)
                            @case(0) Single select @break
                            @case(1) Multi-select @break
                            @case(1) Text input @break
                            @default Unknown
                        @endswitch
                    </td>
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
                            <x-button style="primary" leadingIcon="pen-to-square"/>
                            <x-button style="error" leadingIcon="x"/>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<x-user.template-footer/>
