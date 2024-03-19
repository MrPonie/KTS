<?php

namespace App\View\Components\user;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TemplateHeader extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title='',
        public string $sidebarfocusitem='',
        public string $sidebarfocussubitem='',
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user.template-header');
    }
}
