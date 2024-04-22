<x-user.template-header title="Questions" sidebarfocusitem="Questions"/>

<x-alerts/>

<div class="panel flex-down">
    <div class="w-full flex justify-between">
        <h1>Questions</h1>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Question</th>
                <th>Created by</th>
                <th>Type</th>
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
                    <td>{{ $question->user }}</td>
                    <td>
                        @switch($question->type)
                            @case(0) Single select @break
                            @case(1) Multi-select @break
                            @case(2) Text area @break
                            @case(3) File @break
                            @default Unknown
                        @endswitch
                    </td>
                    <td>{{ $question->evaluable ? $question->points : 0 }}</td>
                    <td>
                        <div class="flex flex-wrap gap-1">
                            @if (!$topics[$index]->isEmpty())
                                @foreach ($topics[$index] as $qt)
                                    <span class="bg-gray-200 rounded p-1">{{ $qt->name }}</span>
                                @endforeach
                            @else
                                <span class="bg-gray-200 rounded p-1">None</span>
                            @endif
                        </div>
                    </td>
                    <td>{{ $question->created_at }}</td>
                    <td>{{ $question->updated_at }}</td>
                    <td>
                        <div class="flex gap-1 items-center">
                            <form action="" method="post" onsubmit="if(!confirm('Are you sure you want to delete this question?')) {return false;}">
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
