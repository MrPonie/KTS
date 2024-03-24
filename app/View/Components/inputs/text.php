<?php

namespace App\View\Components\inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Text extends Component
{
    // public string $type='text';
    // public string $label;
    // public string $name;
    // public string $value='';
    
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type='text',
        public string $label='',
        public string $name='',
        public string $value='',
        public string $class='',
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.inputs.text');
    }
}
