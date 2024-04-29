<x-user.template-header title="Responding to test"/>

<x-alerts/>

@dump(session('debug'))

<div class="panel">
    <div class="flex justify-between items-center">
        <h1>{{ $test->name }}</h1>
        <div>
            <p>Questions: {{ $test->question_count }}</p>
            <p>Max Points: {{ $test->max_points }}</p>
        </div>
    </div>
    
</div>

<form action="{{ route('user.repond_to_test', $id) }}" method="post" class="panel flex flex-col gap-10">
    @csrf
    @foreach ($test->content_json as $question)
        <x-question :question="$question"/>
    @endforeach
    <x-button type="submit" style="primary" text="Sumbit" class="justify-center"/>
</form>

<x-user.template-footer/>