<div class="flex-down">
    <label><input wire:change="check_response_change($event.target.checked)" type="checkbox"> Check if response is correct</label>
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
        @if ($evaluate_response === true)
            <x-inputs.text type="number" name="points" label="Points"/>
        @endif
    </div>
    @switch($type)
        @case(0)
            <livewire:question-single-select/>
            @break
        @case(1)
            <livewire:question-multi-select/>
            @break
        @case(2)
            <div class="flex-down">
                <x-inputs.textarea name="question" label="Question"/>
                <x-inputs.textarea name="answer" label="Answer text"/>
            </div>
            @break
        @case(3)
            <livewire:question-file-upload edit="true"/>
            @break
        @default
            <p>kurwa</p>
    @endswitch
</div>