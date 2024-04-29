<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function questions(Request $request) {
        $questions = \App\Models\Question::select('questions.id', 'questions.type', 'questions.evaluable', 'questions.points', 'questions.question', 'questions.created_at', 'questions.updated_at', 'users.username as user')
            ->leftJoin('users', 'users.id', '=', 'questions.created_by')
            ->leftJoin('topic__questions', 'topic__questions.question_id', '=', 'questions.id');
        // filters
        if($request->input('type') !== null) $questions = $questions->where('questions.type', '=', $request->input('type'));
        if($request->input('topic') !== null) $questions = $questions->where('topic__questions.topic_id', '=', $request->input('topic'));
        if($request->input('by') !== null) $questions = $questions->where('questions.created_by', '=', $request->input('by'));
        if($request->input('search') !== null) $questions = $questions->where('questions.question', 'like', '%'.$request->input('search').'%');
        // get filtered questions
        $questions = $questions->get();

        $question_topics = [];
        foreach($questions as $question) {
            $question_topics[] = \App\Models\Topic::select('name')
                ->leftJoin('topic__questions', 'topic__questions.topic_id', '=', 'topics.id')
                ->where('topic__questions.question_id', '=', $question->id)
                ->get();
        }

        $all_topics = [null=>'None'];
        foreach(\App\Models\Topic::select('id', 'name')->get() as $topic) $all_topics[$topic->id] = $topic->name;

        $teachers = [null=>'None'];
        foreach(\App\Models\User::select('id', 'username')->where('role_id', '=', 2)->get() as $user) $teachers[$user->id] = $user->username;

        return view('admin/questions', ['questions'=>$questions, 'topics'=>$question_topics, 'all_topics'=>$all_topics, 'teachers'=>$teachers]);
    }

    public function question_bank(Request $request) {
        // filter
        $types = [
            '' => 'None',
            0 => 'Single select', 
            1 => 'Multi-select', 
            2 => 'Text area', 
            3 => 'File'
        ];
        $topics = ['' => 'None'];
        $orm_topics = \App\Models\Topic::select('id', 'name')->where('created_by', '=', Auth::id())->get();
        foreach($orm_topics as $topic) {
            $topics[$topic->id] = $topic->name;
        }
        $filter_type = '';
        if($request->input('type') != null) {$filter_type = $request->input('type');}
        $filter_topic = '';
        if($request->input('topic') != null) {$filter_topic = $request->input('topic');}
        // getting filtered questions
        $questions = \App\Models\Question::select('questions.*')->where('questions.created_by', '=', Auth::id());
        if($filter_type != '') {
            $questions = $questions->where('questions.type', '=', $filter_type);
        }
        if($filter_topic != '') {
            $questions = $questions->leftJoin('topic__questions', 'topic__questions.question_id', '=', 'questions.id')->where('topic__questions.topic_id', '=', $filter_topic);
        }
        if($request->input('search') != '') {
            $questions = $questions->where('questions.question', 'like', '%'.$request->input('search').'%');
        }
        $questions = $questions->get();
        $question_topics = [];
        foreach($questions as $question) {
            $question_topics[] = \App\Models\Topic::select('topics.name')
                ->leftJoin('topic__questions', 'topic__questions.topic_id', '=', 'topics.id')
                ->leftJoin('questions', 'questions.id', '=', 'topic__questions.question_id')
                ->where('questions.id', '=', $question->id)
                ->get();
        }
        return view('user/question_bank/question_bank', [
            'questions' => $questions,
            'question_topics' => $question_topics, 
            'types' => $types, 
            'topics' => $topics,
            'filter_type' => $filter_type,
            'filter_topic' => $filter_topic,
        ]);
    }
    
    public function create_view() {return view('user/question_bank/create_new_question');}

    public function create(Request $request) {
        $validated = $request->validate([
            'type' => 'required|string',
            'evaluable' => 'sometimes',
            'points' => 'sometimes|integer',
            'question' => 'required|string',
            'question-input' => 'sometimes|string',
            'answer' => 'sometimes',
            'topics' => 'sometimes|array',
        ]);
        // return back()->with('debug', $request->all());
        if(isset($validated['question-input']) && empty(json_decode($validated['question-input']))) {
            return back()->with('error', 'Question input/options/answer was empty.');
        }

        if(isset($validated['evaluable']) && !isset($validated['answer'])) {
            return back()->with('error', 'Answer was not set.');
        }

        $answer = isset($validated['answer']) ? $validated['answer'] : '';
        $cols = [
            'created_by' => Auth::id(),
            'type' => intval($validated['type']),
            'evaluable' => isset($validated['evaluable']),
            'points' => isset($validated['points']) ? $validated['points'] : 0,
            'question' => $validated['question'],
            'input_json' => isset($validated['question-input']) ? $validated['question-input'] : '',
            'answer_json' => is_string($answer) ? $answer : json_encode($answer),
            'resources_json' => '[]',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ];
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
