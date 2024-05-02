<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Question extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $question, 
        public bool $interactable=true,
        public mixed $answer=null,
        public mixed $answerParsed=null,
        public int $index=0, 
        public int $status=0, // 1 - correct, -1 - incorrect
    ) {
        if($this->answer !== null && is_string($this->answer)) {
            $this->answerParsed = json_decode($this->answer);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.question');
    }
}
