<?php

namespace App\Livewire;

use Livewire\Component;

class UserSelectSearch extends Component
{
    public string $label;
    public string $name;
    public string $value='';
    public string $class='';
    public string $search='';

    public function render()
    {
        $users = null;
        if($this->search) {
            $users = \App\Models\User::select('id', 'username')->where('username', 'like', "%$this->search%")->get();
        }
        // $this->dispatchBrowserEvent('user-select-search-updated', ['item' => $item]);
        return view('livewire.user-select-search', ['users'=>$users]);
    }
}
