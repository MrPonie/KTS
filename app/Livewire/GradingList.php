<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

class GradingList extends Component
{
    public array $list = []; // [ { 'uid' => string, 'percent' => int, 'grade' => string, 'pass' => bool }, ... ]

    public function get_index_by_uid($uid) {
        foreach($this->list as $index=>$item) {
            if($item->uid == $uid) return $index;
        }
        return null;
    }

    public function add() {
        $this->list[] = (object)[
            'uid' => Str::random(8),
            'percent' => 0,
            'grade' => '',
            'pass' => false,
        ];
    }

    public function remove($uid) {
        $index = $this->get_index_by_uid($uid);
        if($index === null) return;
        array_splice($this->list, $index, 1);
    }

    public function percentage_changed($uid, $value) {
        $index = $this->get_index_by_uid($uid);
        if($index === null) return;
        $this->list[$index]->percent = $value;
    }

    public function name_changed($uid, $value) {
        $index = $this->get_index_by_uid($uid);
        if($index === null) return;
        $this->list[$index]->grade = $value;
    }

    public function pass_changed($uid, $value) {
        $index = $this->get_index_by_uid($uid);
        if($index === null) return;
        $this->list[$index]->pass = $value;
    }

    public function render()
    {
        return view('livewire.grading-list', ['grading_json'=>json_encode($this->list)]);
    }
}
