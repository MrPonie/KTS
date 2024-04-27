<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TestFormBuilder extends Component
{
    public array $questions = []; // [ { uid => string, topic => ?int, id => ?int, data => ?array }, ... ]
    public mixed $debug = null;

    public ?int $formID = null;

    public function find_from_uid($uid) {
        foreach($this->questions as $i=>$q) {
            if($q->uid === $uid) return $i;
        }
        return null;
    }

    public function add_question() {
        $kurwa = (object)[];
        $kurwa->uid = bin2hex(random_bytes(4));
        $kurwa->topic = null;
        $kurwa->id = null;
        $kurwa->data = [];
        $this->questions[] = $kurwa;
        $this->debug = $this->questions;
    }

    public function topic_selected($uid, $value) {
        $index = $this->find_from_uid($uid);
        if($index === null) return;
        $this->questions[$index]->topic = $value;
        $this->questions[$index]->id = null;
        $this->questions[$index]->debug = $value;
    }

    public function question_selected($uid, $value) {
        $index = $this->find_from_uid($uid);
        if($index === null) return;
        $this->questions[$index]->id = $value;
    }

    public function points_changed($uid, $value) {
        $index = $this->find_from_uid($uid);
        if($index === null) return;
        $this->questions[$index]->data['points'] = $value;
        $this->debug = $this->questions[$index]->data['points'];
    }

    public function remove_question($uid) {
        $index = $this->find_from_uid($uid);
        if($index === null) return;
        array_splice($this->questions, $index, 1);
    }

    public function move_question_up($uid) {
        $index = $this->find_from_uid($uid);
        if($index === null) return;
        if($index <= 0) return;
        $prev = $index-1;
        $temp = $this->questions[$index];
        $this->questions[$index] = $this->questions[$prev];
        $this->questions[$prev] = $temp;
    }

    public function move_question_down($uid) {
        $index = $this->find_from_uid($uid);
        if($index === null) return;
        if($index+1 >= count($this->questions)) return;
        $next = $index+1;
        $temp = $this->questions[$index];
        $this->questions[$index] = $this->questions[$next];
        $this->questions[$next] = $temp;
    }

    public function render()
    {
        $topics_arr = [];

        // load all topic options
        $topics = \App\Models\Topic::select('id', 'name')
            ->where('created_by', '=', Auth::id())
            ->get();
        foreach($topics as $topic) {
            $topics_arr[$topic->id] = $topic->name;
        }

        if(empty($this->questions) && $this->formID !== null) {
            $form = \App\Models\Test_Form::find($this->formID);
            $fq = $form->questions_json;
            foreach($fq as $q) {
                $q = (object)$q;
                $item = (object)[];
                $item->uid = bin2hex(random_bytes(4));
                $item->topic = $q->topic;
                $item->id = $q->id;
                $item->data = [];
                $this->questions[] = $item;
            }
        }

        foreach($this->questions as $index=>$question) {
            // init data array if null
            if($question->data === null) {$question->data = [];}
            // if question topic is selected load question data
            if($question->topic !== null) {
                // getting selected topic question options and saving to question_options array key
                $topic_questions = \App\Models\Topic_Question::select('questions.id', 'questions.question')
                    ->leftJoin('questions', 'questions.id', '=', 'topic__questions.question_id')
                    ->where('topic__questions.topic_id', '=', $question->topic)
                    ->get();
                foreach($topic_questions as $tq) {
                    $question->data['question_options'][$tq->id] = $tq->question;
                }
                // if question is selected load question data for rendering
                if($question->id !== null) {
                    $selected_question = \App\Models\Question::find($question->id);
                    $question->data['question'] = $selected_question->question;
                    $question->data['evaluable'] = $selected_question->evaluable;
                    $question->data['points'] = $selected_question->evaluable ? $selected_question->points : 0;
                    $question->data['type'] = $selected_question->type;
                    $question->data['input_json'] = $selected_question->input_json;

                }
            }
        }

        // calculate current form max points
        $max_points = 0;
        foreach($this->questions as $question) {
            if(array_key_exists('points', $question->data)){
                $max_points += $question->data['points'];
            }
        }

        // create a new questions json that will be sent on submit
        $form_questions = [];
        foreach($this->questions as $question) {
            $form_questions[] = (object)['topic' => $question->topic, 'id' => $question->id, 'points' => array_key_exists('points', $question->data) ? $question->data['points'] : 0];
        }
        $form_questions = json_encode($form_questions);

        return view('livewire.test-form-builder', [
            'topics' => $topics_arr,
            'form_questions' => $form_questions,
            'max_points' => $max_points,
        ]);
    }
}
