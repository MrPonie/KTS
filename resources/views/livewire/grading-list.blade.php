<div class="w-full">
    <input type="hidden" name="grading" value="{{ $grading_json }}">
    <label>Grading</label>
    <div class="flex-down border border-gray-200 rounded p-2">
        <div class="flex-down">
            @foreach ($list as $item)
                <div class="flex gap-1">
                    <x-inputs.text wire:change="percentage_changed('{{ $item->uid }}', $event.target.value)" type="number" class="w-full" label="Grade percentage"/>
                    <x-inputs.text wire:change="name_changed('{{ $item->uid }}', $event.target.value)" type="text" class="w-full" label="Grade name"/>
                    <div class="shrink-0 flex flex-col gap-1 items-center">
                        <label>Is a passing grade</label>
                        <div class="flex items-center">
                            <x-inputs.checkbox wire:change="pass_changed('{{ $item->uid }}', $event.target.checked)"/>
                        </div>
                    </div>
                    <x-button wire:click="remove('{{ $item->uid }}')" style="error-outline" leadingIcon="x"/>
                </div>
            @endforeach
        </div>
        <x-button wire:click="add()" style="secondary-outline" text="Add" class="w-full justify-center"/>
    </div>
</div>