<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class icon extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $icon, public string $family='', public string $style='regular'){}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.icon');
    }
}