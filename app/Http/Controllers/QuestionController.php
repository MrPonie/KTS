<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    public function question_bank() {
        $questions = \App\Models\Question::select('questions.*')->get();
        $question_topics = [];
        foreach($questions as $question) {
            $question_topics[] = \App\Models\Topic::select('topics.name')
                ->leftJoin('topic__questions', 'topic__questions.topic_id', '=', 'topics.id')
                ->leftJoin('questions', 'questions.id', '=', 'topic__questions.question_id')
                ->where('questions.id', '=', $question->id)
                ->get();
        }
        return view('user/question_bank/question_bank', ['questions' => $questions, 'question_topics' => $question_topics]);
    }
    
    public function create_view() {return view('user/question_bank/create_new_question');}

    public function create(Request $request) {
        $validated = $request->validate([
            'type' => 'required|string',
            'evaluable' => 'sometimes',
            'points' => 'sometimes|integer',
            'question' => 'required|string',
            'question-input' => 'required|string',
            'answer' => 'sometimes',
            'topics' => 'sometimes|array',
        ]);
        // return back()->with('debug', $request->all());
        if(empty(json_decode($validated['question-input']))) {
            return back()->with('error', 'Question input/options/answer was empty.');
        }

        if(isset($validated['has_correct_answer']) && !isset($validated['answer'])) {
            return back()->with('error', 'Answer was not set.');
        }

        $answer = isset($validated['answer']) ? $validated['answer'] : '';
        $cols = [
            'created_by' => Auth::id(),
            'type' => intval($validated['type']),
            'evaluable' => isset($validated['has_correct_answer']),
            'question' => $validated['question'],
            'input_json' => $validated['question-input'],
            'answer_json' => is_string($answer) ? $answer : json_encode($answer),
            'resources_json' => '[]',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ];
        if(isset($validated['points'])) {$cols['points'] = $validated['points'];}
        $question = \App\Models\Question::create($cols);
        
        if(!$question->save()) {
            return back()->with('error', 'Failed to create a new question.');
        }

        if(isset($validated['topics'])) {
            foreach($validated['topics'] as $topic) {
                $record = new \App\Models\Topic_Question;
                $record->topic_id = $topic;
                $record->question_id = $question->id;
                $record->save();
            }
        }

        return back()->with('success', 'New question created!');
    }

    public function delete(Request $request) {
        $validated = $request->validate([
            'id' => 'required|integer'
        ]);

        // check if question of ID exists
        $question = \App\Models\Question::find($validated['id']);
        if(empty($question)) {
            return back()->with('error', 'Could not find question of the ID.');
        }

        // delete question from topics
        \App\Models\Topic_Question::where('question_id', '=', $validated['id'])->delete();

        // delete question
        \App\Models\Question::where('id', '=', $validated['id'])->delete();

        return back()->with('success', 'Deleted the question.');
    }

    public function edit_view(Request $request, int $id) {
        $question = \App\Models\Question::find($id);
        if(!$question) {return back()->with('errors', 'Failed to find question.');}
        $topics = \App\Models\Topic::select('topics.id', 'topics.name')
            ->leftJoin('topic__questions', 'topic__questions.topic_id', '=', 'topics.id')
            ->where('topic__questions.question_id', '=', $id)
            ->get();
        $topic_list = [];
        foreach($topics as $topic) {
            $topic_list[] = (object)[
                'id' => $topic->id,
                'name' => $topic->name,
            ];
        }

        return view('user/question_bank/edit_question', ['id'=>$id, 'question'=>$question, 'topics'=>$topic_list]);
    }

    public function edit(Request $request, int $id) {
        $validated = $request->validate([
            'type' => 'required|string',
            'evaluable' => 'sometimes',
            'points' => 'sometimes|integer',
            'question' => 'required|string',
            'question-input' => 'sometimes|string',
            'answer' => 'sometimes',
            'topics' => 'sometimes|array',
        ]);

        $question = \App\Models\Question::find($id);
        if(!$question) {
            return back()->with('error', 'Could not find the question to update of ID.');
        }

        $question->type = intval($validated['type']);
        $question->evaluable = isset($validated['evaluable']);
        if(isset($validated['points'])){
            $question->points = $validated['points'];
        }
        $question->question = $validated['question'];
        if(isset($validated['question-input'])) {
            $question->input_json = $validated['question-input'];
        }
        $answer = isset($validated['answer']) ? $validated['answer'] : '';
        $question->answer_json = is_string($answer) ? $answer : json_encode($answer);
        $question->resources_json = '[]';
        $question->updated_at = \Carbon\Carbon::now();

        if(!$question->save()) {
            return back()->with('error', 'Failed to update question of ID.');
        }

        // stinky but don't have much time
        \App\Models\Topic_Question::where('question_id', '=', $id)->delete();
        if(isset($validated['topics'])) {
            foreach($validated['topics'] as $topic) {
                $record = new \App\Models\Topic_Question;
                $record->question_id = $id;
                $record->topic_id = $topic;
                $record->created_at = \Carbon\Carbon::now();
                $record->updated_at = \Carbon\Carbon::now();
                $record->save();
            }
        }

        return back()->with('success', 'Successfuly updated the question!');
    }
}
