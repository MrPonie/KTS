<x-user.template-header title="View Response"/>

<x-alerts/>

<div class="panel">
    <div class="flex justify-between items-center">
        <h1>{{ $test->name }}</h1>
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
        <x-question :question="$question" :index="$index" :answer="$response->response_json[$index]" :interactable="false"/>
    @endforeach
</div>

<x-user.template-footer/>