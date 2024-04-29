<div class="flex-down">
@switch($question['type'])
    @case(0)
        <p>{!! $question['question'] !!}</p>
        @foreach (json_decode($question['input_json']) as $option)
            <label class="flex gap-2">
                <input type="radio" name="answer[]" value="{{ $option->id }}">
                <p>{{ $option->text }}</p>
            </label>
        @endforeach
        @break
    @case(1)
        <p>{!! $question['question'] !!}</p>
        @foreach (json_decode($question['input_json']) as $option)
            <label class="flex gap-2">
                <input type="checkbox" name="answer[]" value="{{ $option->id }}">
                <p>{{ $option->text }}</p>
            </label>
        @endforeach
        @break
    @case(2)
        <p>{!! $question['question'] !!}</p>
        <x-inputs.textarea name="answer[]"/>
        @break
    @case(3)
        file
        @break
    @default
        oh no
@endswitch
</div>