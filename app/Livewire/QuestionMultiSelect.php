<?php

namespace App\Livewire;

use Livewire\Component;

class QuestionMultiSelect extends Component
{
    public bool $edit = false;
    public bool $showanswer = false;
    public ?\App\Models\Question $question = null;

    public ?array $options = null;

    public function option_name_changed($index, $value) {
        if($index !== null) {
            $this->options[$index]['text'] = $value;
        }
    }

    public function option_check_changed($index, $value) {
        if($index !== null) {
            $this->options[$index]['checked'] = $value;
        }
    }

    public function add() {
        if(!$this->options) {
            $this->options = [];
        }

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

    public function remove($index) {
        if($index !== null) {
            array_splice($this->options, $index, 1);
        }
    }

    public function up($index) {
        if($index > 0) {
            $prev = $this->options[$index-1];
            $this->options[$index-1] = $this->options[$index];
            $this->options[$index] = $prev;
        }
    }

    public function down($index) {
        if($index+1 < count($this->options)) {
            $prev = $this->options[$index+1];
            $this->options[$index+1] = $this->options[$index];
            $this->options[$index] = $prev;
        }
    }

    public function render()
    {
        if(!$this->options) {
            $this->options = [];
            if($this->question) {
                $options = json_decode($this->question->input_json);
                $answers = json_decode($this->question->answer_json);
                if(!is_array($answers)) {$answers = [];}
                foreach($options as $option) {
                    $this->options[] = [
                        'id' => $option->id,
                        'text' => $option->text,
                        'checked' => $this->showanswer ? (!empty($answers) ? in_array($option->id, $answers) : false) : false,
                    ];
                }
            }
        }

        $question_input_arr = [];
        foreach($this->options as $option) {
            $question_input_arr[] = [
                'id' => $option['id'],
                'text' => $option['text'],
            ];
        }

        return view('livewire.question-multi-select', [
            'question_name' => old('question') ?: ($this->question ? $this->question->question : ''),
            'question_input' => json_encode($question_input_arr)
        ]);
    }
}
