<?php

namespace App\View\Components\inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class text extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type='text',
        public string $label,
        public string $name,
        public string $value='',
    ){}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.inputs.text');
    }
}
