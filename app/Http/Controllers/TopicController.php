<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TopicController extends Controller
{
    public function question_bank_topics() {
        $topics = \App\Models\Topic::select('topics.*', DB::raw('count(topic__questions.id) as question_count'))
            ->leftJoin('topic__questions', 'topic__questions.topic_id', '=', 'topics.id')
            ->groupBy('topics.id', 'topics.name', 'topics.description', 'topics.created_at', 'topics.updated_at', 'topics.created_by')
            ->where('topics.created_by', '=', Auth::id())->get();
        return view('user/question_bank/question_bank_topics', ['topics'=>$topics]);
    }

    public function create_view() {return view('user/question_bank/create_new_topic');}

    public function create(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $topic = new \App\Models\Topic;
        $topic->created_by = Auth::id();
        $topic->name = $validated['name'];
        $topic->description = $validated['description'];
        $topic->created_at = \Carbon\Carbon::now();
        $topic->updated_at = \Carbon\Carbon::now();

        if($topic->save()){
            return back()->with('success', 'Created new topic!');
        }else{
            return back()->with('error', 'Failed to create a new topic.');
        }
    }

    public function edit_view(Request $request, int $id) {
        $topics = \App\Models\Topic::select('*')->where('id', '=', $id)->get();
        return view('user/question_bank/edit_topic', ['topic'=>$topics[0]]);
    }

    public function edit(Request $request, int $id) {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $topic = \App\Models\Topic::find($id);
        if(!$topic) {return back()->with('error', 'Did not find topic of ID.');}

        $topic->name = $validated['name'];
        $topic->description = $validated['description'];
        $topic->updated_at = \Carbon\Carbon::now();

        if($topic->save()){
            return back()->with('success', 'Successfuly updated topic!');
        }else{
            return back()->with('error', 'Failed to update topic.');
        }
    }
}
