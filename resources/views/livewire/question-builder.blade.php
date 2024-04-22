<div class="flex-down">
    <label><input wire:change="check_response_change($event.target.checked)" type="checkbox" name="evaluable" @checked($evaluable)> Check if response is correct</label>
    @error('points')
        <p class="input-error">{{ $message }}</p>
    @enderror
    <div class="flex gap-2">
        <div class="grow flex flex-col gap-1">
            <label>Type</label>
            <select wire:model.change="type" name="type" class="input-select">
                <option value hidden>Select</option>
                @foreach ($types as $value=>$name)
                    <option value="{{ $value }}" @selected($type == $value)>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        @if (($question && $question->evaluable) || $evaluable)
            <x-inputs.text type="number" name="points" label="Points" :value="$points"/>
            @error('points')
                <p class="input-error">{{ $message }}</p>
            @enderror
        @endif
    </div>
    @switch($type)
        @case(0)
            <livewire:question-single-select :question="$question" :showanswer="true"/>
            @break
        @case(1)
            <livewire:question-multi-select :question="$question" :showanswer="true"/>
            @break
        @case(2)
            <div class="flex-down">
                <x-inputs.textarea name="question" label="Question" :value="$question ? $question->question : ''"/>
                @php
                    $answer = '';
                    if($question) {
                        $answer = json_decode($question->answer_json);
                        if(is_array($answer) || is_object($answer)) {$answer = '';}
                        if(!$answer) {$answer = $question->answer_json;}
                    }
                @endphp
                <x-inputs.textarea name="answer" label="Answer text" :value="$answer"/>
            </div>
            @break
        @case(3)
            <livewire:question-file-upload edit="true"/>
            @break
        @default
            <p>kurwa</p>
    @endswitch
</div>