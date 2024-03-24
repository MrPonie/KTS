<div class="flex-down">
    @foreach ($options as $option)
        @dump($option)
    @endforeach
    <x-inputs.textarea name="question" label="Question" value="{{ $question }}"/>
    <label>Options</label>
    <div class="flex-down p-2 border border-gray-200 rounded">
        <div class="options flex-down">
            @foreach ($options as $index=>$option)
                <div class="option flex gap-2">
                    <p>{{ $option['id'] }}</p>
                    <div class="grow">
                        <label class="flex gap-2">
                            <input wire:change="option_check_changed({{ $option['id'] }})" type="radio" name="answer" value="{{ $option['id'] }}" @checked($option['checked'])>
                            <textarea wire:change="option_name_changed({{ $option['id'] }}, $event.target.value)" class="w-full input-textarea" cols="30" rows="2">{{ $option['text'] }}</textarea>
                        </label>
                    </div>
                    <div class="flex gap-2">
                        <!-- <button type="button" wire:click="up({{ $option['id'] }})" class="button-secondary flex justify-center">
                            <x-icon icon="arrow-up" style="solid"/>
                        </button>
                        <button type="button" wire:click="down({{ $option['id'] }})" class="button-secondary flex justify-center">
                            <x-icon icon="arrow-down" style="solid"/>
                        </button> -->
                        <button type="button" wire:click="remove({{ $option['id'] }})" class="button-error flex justify-center">
                            <x-icon icon="x"/>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="button" wire:click="add()" class="button-secondary flex justify-center">
            <span><x-icon icon="plus"/></span> Add
        </button>
    </div>
</div>