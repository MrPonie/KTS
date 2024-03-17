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
        public string $leadingIcon='',
        public string $leadingIconStyle='',
        public string $trailingIcon='',
        public string $trailingIconStyle='',
        public string $title='',
        public bool $disabled=false, 
        public string $id='',
        public string $class='') {
        $this->buttonClass = match($style) {
            'primary' => 'button-primary',
            'primary-outline' => 'button-primary-outline',
            'primary-filled' => 'button-primary-filled',
            'secondary' => 'button-secondary',
            'secondary-outline' => 'button-secondary-outline',
            'secondary-filled' => 'button-secondary-filled',
            'success' => 'button-success',
            'success-outline' => 'button-success-outline',
            'success-filled' => 'button-success-filled',
            'warning' => 'button-warning',
            'warning-outline' => 'button-warning-outline',
            'warning-filled' => 'button-warning-filled',
            'error' => 'button-error',
            'error-outline' => 'button-error-outline',
            'error-filled' => 'button-error-filled',
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
