<?php

namespace App\View\Components\Navlist;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navlist extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public mixed $list, public string $focusitem='', public string $focussubitem=''){}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navlist.navlist');
    }
}
