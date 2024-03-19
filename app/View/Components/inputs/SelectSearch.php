<?php

namespace App\View\Components\inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectSearch extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name='',
        public string $label='',
        public string $id='',
        public string $class='',
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.inputs.select-search');
    }
}
