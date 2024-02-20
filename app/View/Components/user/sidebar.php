<?php

namespace App\View\Components\user;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class sidebar extends Component
{
    public array $list;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->list[] = ['name'=>'Assigned Tests','link'=>'#'];
        $this->list[] = ['name'=>'Test Results','link'=>'#'];

        $this->list[] = ['name'=>'Question Bank','link'=>'#','sublist'=>[
            ['name'=>'Topics','link'=>'#'],
            ['name'=>'Create new question','link'=>'#'],
            ['name'=>'Create new topic','link'=>'#'],
        ]];
        $this->list[] = ['name'=>'Test forms','link'=>'#','sublist'=>[
            ['name'=>'Create new test form','link'=>'#'],
            ['name'=>'Export test form','link'=>'#'],
        ]];
        $this->list[] = ['name'=>'Tests','link'=>'#','sublist'=>[
            ['name'=>'Create new test','link'=>'#'],
        ]];

        $this->list[] = ['name'=>'Users','link'=>'#','sublist'=>[
            ['name'=>'Create new user','link'=>'#'],
        ]];
        $this->list[] = ['name'=>'Questions','link'=>'#'];
        $this->list[] = ['name'=>'Topics','link'=>'#'];
        $this->list[] = ['name'=>'Test Forms','link'=>'#'];
        $this->list[] = ['name'=>'Tests','link'=>'#'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user.sidebar');
    }
}
