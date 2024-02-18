<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class button extends Component
{
    public string $buttonClass;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type='button', 
        public string $style='primary', 
        public string $text='', 
        public string $link='#', 
        public bool $disabled=false, 
        public string $class='') {
        $this->buttonClass = match($style) {
            'primary' => 'button-primary',
            'primary-outline' => 'button-primary-outline',
            'primary-filled' => 'button-primary-filled',
            default => 'button-primary',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}
