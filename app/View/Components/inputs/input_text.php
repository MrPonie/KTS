<?php

namespace App\View\Components\inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class input_text extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type='text',
        public string $label,
        public string $name
    ){}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.inputs.input_text');
    }
}
