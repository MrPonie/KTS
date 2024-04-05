<?php

namespace App\Livewire;

use Livewire\Component;

class QuestionSingleSelect extends Component
{
    public bool $edit = false;
    public bool $showanswer = false;
    public ?\App\Models\Question $question = null;

    public ?array $options = null; // [ [ 'id'=>integer, 'text'=>string, 'checked'=>boolean ], ... ]

    public function option_name_changed($index, $value) {
        $this->options[$index]['text'] = $value;
    }

    public function option_check_changed($index) {
        foreach($this->options as $i=>&$option) {
            $option['checked'] = $i == $index;
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
                $answer = !is_array($answers) && !is_object($answers) ? $answers : null;
                foreach($options as $option) {
                    $this->options[] = [
                        'id' => $option->id,
                        'text' => $option->text,
                        'checked' => $this->showanswer ? $answer == $option->id : false,
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
        
        return view('livewire.question-single-select', [
            'question_name' => old('question') ?: ($this->question ? $this->question->question : ''),
            'question_input' => json_encode($question_input_arr)
        ]);
    }
}
