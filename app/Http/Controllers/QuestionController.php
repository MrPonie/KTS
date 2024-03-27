<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

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
    
    public function create_new_question_view() {return view('user/question_bank/create_new_question');}

    public function create_new_question(Request $request) {
        $validated = $request->validate([
            'type' => 'required|string',
            'points' => 'sometimes|string',
            'question' => 'required|string',
            'question-input' => 'required|string',
            'answer' => 'sometimes',
        ]);

        $question = new \App\Models\Question;
        $question->created_by = Auth::id();
        $question->type = intval($validated['type']);
        $question->body_json = $validated['question'];
        $question->input_json = $validated['question-input'];
        $question->answer_json = is_string($validated['answer']) ? $validated['answer'] : json_encode($validated['answer']);
        $question->resources_json = '[]';
        $question->created_at = \Carbon\Carbon::now();
        $question->updated_at = \Carbon\Carbon::now();

        if($question->save()) {
            return back()->with('success', 'New question created!');
        }else{
            return back()->with('error', 'Failed to create a new question.');
        }

        $html = '<pre>';
        $html .= var_export($request->all());
        $html .= '</pre>';
        return $html;
    }
}
