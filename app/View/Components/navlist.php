<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use Illuminate\Support\Arr;

class navlist extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public array $list) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navlist');
    }
}