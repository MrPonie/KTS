<?php $rnd = 'nx'.bin2hex(random_bytes(3));?>
<div class="flex-down">
    <input type="hidden" name="question-input" value="{{ $question_input }}">
    @error('question-input')
        <p class="input-error">{{$message}}</p>
    @enderror
    <x-inputs.textarea name="question" label="Question" value="{{ $question_name }}"/>
    <label>Options</label>
    <div class="flex-down p-2 border border-gray-200 rounded">
        <div class="options flex-down">
            @foreach ($options as $index=>$option)
                <div class="option flex gap-2">
                    <div class="grow">
                        <{{ $rnd }}>
                        <label class="flex gap-2">
                            <input wire:change="option_check_changed({{ $index }}, $event.target.checked)" type="checkbox" name="answer[]" value="{{ $option['id'] }}" @checked($option['checked'])>
                            <textarea wire:change="option_name_changed({{ $index }}, $event.target.value)" class="w-full input-textarea" cols="30" rows="2">{{ $option['text'] }}</textarea>
                        </label>
                        </{{ $rnd }}>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" wire:click="up({{ $index }})" class="button-secondary flex justify-center" >
                            <x-icon icon="arrow-up" style="solid"/>
                        </button>
                        <button type="button" wire:click="down({{ $index }})" class="button-secondary flex justify-center">
                            <x-icon icon="arrow-down" style="solid"/>
                        </button>
                        <button type="button" wire:click="remove({{ $index }})" class="button-error flex justify-center">
                            <x-icon icon="x"/>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        @error('answer')
            <p class="input-error">{{$message}}</p>
        @enderror
        <button type="button" wire:click="add()" class="button-secondary flex justify-center">
            <span><x-icon icon="plus"/></span> Add
        </button>
    </div>
</div>