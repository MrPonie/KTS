<?php

namespace App\Livewire;

use Livewire\Component;

class QuestionBuilder extends Component
{
    public array $types = [
        0 => 'Single select',
        1 => 'Multi select',
        2 => 'Text area',
        3 => 'File',
    ];
    public int $type=0;
    public bool $evaluate_response = false;

    public function check_response_change($checked) {
        $this->evaluate_response = $checked;
    }

    public function render()
    {
        return view('livewire.question-builder');
    }
}
