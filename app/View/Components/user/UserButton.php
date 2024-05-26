<?php

namespace App\View\Components\User;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserButton extends Component
{
    public string $sukasukasukasuksasuka;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->sukasukasukasuksasuka = bin2hex(random_bytes(3));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user.user-button');
    }
}
