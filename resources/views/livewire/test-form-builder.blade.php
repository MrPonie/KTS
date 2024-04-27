<?php $rnd = 'fq'.bin2hex(random_bytes(3));?>
<div class="flex-down">
    <p>Max points: {{ $max_points }}</p>
    <x-inputs.text type="hidden" name="questions" value="{{ $form_questions }}"/>
    <div class="questions-container">
        @foreach ($questions as $question)
            <div class="flex gap-2" wire:key="{{ $question->uid }}">
                <div class="w-full">
                    <div class="flex gap-2">
                        <x-inputs.select wire:change="topic_selected('{{ $question->uid }}', $event.target.value)" label="Topic" class="flex-grow" :options="$topics" selected="{{ $question->topic }}"/>
                        <x-inputs.select wire:change="question_selected('{{ $question->uid }}', $event.target.value)" label="Question" class="flex-grow" :options="isset($question->data['question_options']) ? $question->data['question_options'] : []" selected="{{ $question->id }}"/>
                        {{-- <x-inputs.text wire:change="points_changed('{{ $question->uid }}', $event.target.value)" type="number" label="Points" value="{{ $question->id ? $question->data['points'] : ''}}" :disabled="array_key_exists('evaluable', $question->data) ? !$question->data['evaluable'] : true"/> --}}
                        <x-inputs.text wire:change="points_changed('{{ $question->uid }}', $event.target.value)" type="number" label="Points" value="{{ $question->id ? $question->data['points'] : ''}}" :disabled="true"/>
                    </div>
                    <label>Preview</label>
                    <div class="flex-down border border-gray-200 rounded p-2">
                        @if ($question->id)
                            @switch($question->data['type'])
                                @case(0)
                                    <div class="flex-down">
                                        <p>{{ $question->data['question'] }}</p>
                                        <div class="flex-down p-2">
                                            <?php
                                                $input = json_decode($question->data['input_json']);
                                                $options = [];
                                                foreach($input as $option) {
                                                    $options[$option->id] = $option->text;
                                                }
                                            ?>
                                            @foreach ($options as $index=>$option)
                                                <div class="option grow flex gap-2">
                                                    <label class="flex gap-2">
                                                        <input type="radio" disabled>
                                                        <span>{{ $option }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @break
                                @case(1)
                                    <div class="flex-down">
                                        <p>{{ $question->data['question'] }}</p>
                                        <div class="flex-down p-2">
                                            <?php
                                                $input = json_decode($question->data['input_json']);
                                                $options = [];
                                                foreach($input as $option) {
                                                    $options[$option->id] = $option->text;
                                                }
                                            ?>
                                            @foreach ($options as $index=>$option)
                                                <div class="option grow flex gap-2">
                                                    <label class="flex gap-2">
                                                        <input type="checkbox" disabled>
                                                        <span>{{ $option }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @break
                                @case(2)
                                    <div class="flex-down">
                                        <p>{{ $question->data['question'] }}</p>
                                        <div class="flex-down p-2">
                                            <textarea cols="30" rows="2" disabled></textarea>
                                        </div>
                                    </div>
                                    @break
                                @default
                            @endswitch
                        @endif
                    </div>
                </div>
                <div class="grid grid-rows-3 gap-2">
                    <x-button wire:click="move_question_up('{{ $question->uid }}')" type="button" style="secondary" trailingIcon="arrow-up" trailingIconStyle="solid" class=""/>
                    <x-button wire:click="remove_question('{{ $question->uid }}')" type="button" style="error" trailingIcon="x"/>
                    <x-button wire:click="move_question_down('{{ $question->uid }}')" type="button" style="secondary" trailingIcon="arrow-down" trailingIconStyle="solid"/>
                </div>
            </div>
        @endforeach
    </div>
    <x-button wire:click="add_question()" type="button" style="secondary-outline" text="Add" class="justify-center w-full"/>
</div>
