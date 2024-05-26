<?php

namespace App\Livewire;

use Livewire\Component;

class QuestionBuilder extends Component
{
    public array $types = [
        0 => 'Single select',
        1 => 'Multi select',
        2 => 'Text area',
    ];
    public ?\App\Models\Question $question = null;
    
    public ?int $type = null;
    public ?bool $evaluable = null;

    public function check_response_change($checked) {
        $this->evaluable = $checked;
    }

    public function render()
    {
        if($this->type == null) {
            $this->type = old('type') ?: ($this->question ? $this->question->type : 0);
        }
        if($this->evaluable == null) {
            $this->evaluable = old('evaluable') ? true : ($this->question ? $this->question->evaluable : false);
        }
        return view('livewire.question-builder', [
            'evaluable' => $this->evaluable,
            'points' => old('points') ?: ($this->question ? $this->question->points : 0),
        ]);
    }
}
