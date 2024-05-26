<x-user.template-header title="View Response"/>

<x-alerts/>

<div class="panel">
    <div class="flex justify-between items-center">
        <div>
            <p>{{ $user->username }}</p>
            <h1>{{ $test->name }}</h1>
        </div>
        <div class="flex gap-2">
            <div>
                <p>Questions: {{ $test->question_count }}</p>
                <p>Max Points: {{ $test->max_points }}</p>
            </div>
            <div>
                <p>Points: {{ $response->points }}</p>
                <p>Grade: <span class="{{ $response->passed ? 'text-green-500' : 'text-red-500' }}">{{ $response->grade }}</span></p>
            </div>
        </div>
    </div>
    
</div>

<div class="panel flex flex-col gap-10">
    @foreach ($test->content_json as $index=>$question)
        <div class="flex">
            <div class="w-full">
                <x-question :question="$question" :index="$index" :answer="$response->response_json[$index]" :interactable="false"/>
            </div>
            {{-- <x-button type="link" style="success" leadingIcon="check" leadingIconStyle="solid" title="Mark correct" link="{{ route('edit_test_response', [$id, $index, 1]) }}"/>
            <x-button type="link" style="error" leadingIcon="x" leadingIconStyle="solid" title="Mark incorrect" link="{{ route('edit_test_response', [$id, $index, 0]) }}"/> --}}
        </div>
    @endforeach
</div>

<x-user.template-footer/>