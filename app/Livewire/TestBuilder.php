<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TestBuilder extends Component
{
    public array $forms = [];
    public ?int $selected = null;

    public function form_selected($index) {
        $this->selected = $index;
    }

    public function render()
    {
        if(empty($forms)) {
            $found = \App\Models\Test_Form::select('id', 'name')->where('created_by', '=', Auth::id())->get();
            foreach($found as $form) {
                $this->forms[$form->id] = $form->name;
            }
        }

        if($this->selected !== null) {

        }

        return view('livewire.test-builder', ['forms'=>$this->forms]);
    }
}
