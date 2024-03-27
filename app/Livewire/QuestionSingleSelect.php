<?php

namespace App\Livewire;

use Livewire\Component;

class QuestionSingleSelect extends Component
{
    public bool $edit = false;
    public bool $showanswer = false;
    public string $question = '';
    public array $options = [];

    public string $question_input = '';

    public function get_option_index_by_id($id) {
        foreach($this->options as $index=>$option) {
            if($option['id'] == $id) {
                return $index;
            }
        }
        return null;
    }

    public function option_name_changed($id, $value) {
        $index = $this->get_option_index_by_id($id);
        if($index !== null) {
            $this->options[$index]['text'] = $value;
        }
    }

    public function option_check_changed($id) {
        foreach($this->options as $index=>&$option) {
            $option['checked'] = $option['id'] == $id;
        }
    }

    public function add() {
        $next_index = 0;
        foreach($this->options as &$option){
            if($option['id'] > $next_index){
                $next_index = $option['id'];
            }
        }
        $next_index++;
        $this->options[] = [
            'id' => $next_index,
            'text' => '',
            'checked' => false,
        ];
    }

    public function remove($id) {
        $index = $this->get_option_index_by_id($id);
        if($index !== null) {
            array_splice($this->options, $index, 1);
        }
    }

    public function up($id) {
        $index = $this->get_option_index_by_id($id);
        if($index > 0) {
            $prev = $this->options[$index-1];
            $this->options[$index-1] = $this->options[$index];
            $this->options[$index] = $prev;
        }
    }

    public function down($id) {
        $index = $this->get_option_index_by_id($id);
        if($index+1 < count($this->options)) {
            $prev = $this->options[$index+1];
            $this->options[$index+1] = $this->options[$index];
            $this->options[$index] = $prev;
        }
    }

    public function render()
    {
        $question_input_arr = [];
        foreach($this->options as $option) {
            $question_input_arr[] = [
                'id' => $option['id'],
                'text' => $option['text'],
            ];
        }
        $this->question_input = json_encode($question_input_arr);
        return view('livewire.question-single-select');
    }
}
