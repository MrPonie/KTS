@php
    $question_answer = $question['type'] == 1 ? json_decode($question['answer_json']) : $question['answer_json'];
    $ans = is_array($answer) ? $answer['answer'] : null;
@endphp
<div class="flex-down {{ $answer!==null ? ($answer['correct'] ? 'border border-green-500 p-2 rounded' : 'border border-red-500 p-2 rounded') : '' }}">
    <div class="flex gap-1">
        <p class="grow">{!! $question['question'] !!}</p>
        @if ($answer !== null)
            <p>{{ $answer['correct'] ? '+'.$question['points'] : '+0' }}</p>
        @endif
    </div>
@switch($question['type'])
    @case(0)
        @foreach (json_decode($question['input_json']) as $option)
            <label class="flex gap-2">
                <input type="radio" name="answer[{{ $index }}]" value="{{ $option->id }}" @checked($option->id==$ans) @disabled(!$interactable)>
                <p>{{ $option->text }}</p>
            </label>
        @endforeach
        @break
    @case(1)
        @foreach (json_decode($question['input_json']) as $option)
            <label class="flex gap-2">
                <input type="checkbox" name="answer[{{ $index }}][]" value="{{ $option->id }}" @checked(is_array($answer) && in_array($option->id, $ans)) @disabled(!$interactable)>
                <p>{{ $option->text }}</p>
            </label>
        @endforeach
        @break
    @case(2)
        <x-inputs.textarea name="answer[{{ $index }}]" value="{{ $ans }}" asd="asd"/>    
        @break
    @case(3)
        file
        @break
    @default
        oh no
@endswitch
</div>