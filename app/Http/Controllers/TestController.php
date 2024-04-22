<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\support\Carbon;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function list() {
        $tests = \App\Models\Test::select('tests.*', DB::raw('count(test__users.user_id) as user_count'))
            ->leftJoin('test__users', 'test__users.test_id', '=', 'tests.id')
            ->groupBy('tests.id', 'tests.created_by', 'tests.name', 'tests.is_active', 'tests.content_json', 'tests.question_count', 'tests.max_points', 'tests.created_at', 'tests.updated_at')
            ->get();
        return view('user/test_list/test_list', ['tests'=>$tests]);
    }

    public function create_view(Request $request) {
        return view('user/test_list/create_test');
    }

    public function create(Request $request) {
        $validated = $request->validate([
            'groups' => 'required|array',
            'form' => 'required',
            'grading' => 'required|string',
        ]);

        $users = [];
        foreach($validated['groups'] as $group) {
            $u = \App\Models\Group_User::select('id')->where('group_id', '=', $group)->get();
            // return back()->with('error', json_encode($u));
            foreach($u as $uu) {$users[] = $uu->id;}
        }

        $form = \App\Models\Test_Form::find($validated['form']);
        if(!$form) return back()->with('error', 'Failed to find selected test form.');

        $test = new \App\Models\Test;
        $test->created_by = Auth::id();
        $test->name = $form->name;
        $test->is_active = false;
        $test->content_json = $form->questions_json;
        $test->question_count = $form->question_count;
        $test->max_points = $form->max_points;
        $test->created_at = \Carbon\Carbon::now();
        $test->updated_at = \Carbon\Carbon::now();

        $cols = [
            'created_by' => Auth::id(),
            'name' => $form->name,
            'is_active' => false,
            'content_json' => $form->questions_json,
            'question_count' => $form->question_count,
            'max_points' => $form->max_points,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ];
        $test = \App\Models\Test::create($cols);

        if(!$test) return back()->with('error', 'Failed to create a new test.');

        foreach($users as $u) {
            $record = new \App\Models\Test_User;
            $record->user_id = $u;
            $record->test_id = $test->id;
            $record->created_at = \Carbon\Carbon::now();
            $record->updated_at = \Carbon\Carbon::now();
            $record->save();
        }

        return back()->with('success', 'Successfuly created a new test!');
    }

    public function start(Request $request, int $id) {
        $test = \App\Models\Test::find($id);
        if(!$test) return back()->with('error', 'Failed to find test of ID.');
        $test->is_active = true;
        if($test->save()) return back()->with('success', 'Successfuly started the test.');
        return back()->with('error', 'Failed to start test.');
    }

    public function stop(Request $request, int $id) {
        $test = \App\Models\Test::find($id);
        if(!$test) return back()->with('error', 'Failed to find test of ID.');
        $test->is_active = false;
        if($test->save()) return back()->with('success', 'Successfuly stopped the test.');
        return back()->with('error', 'Failed to start test.');
    }
}
