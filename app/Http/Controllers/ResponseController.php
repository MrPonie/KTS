<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\support\Carbon;
use Illuminate\Support\Facades\DB;

class ResponseController extends Controller
{
    public function test_results_view(Request $request, int $id) {
        $response = \App\Models\Response::find($id);
        if(!$response) return back()->with('error', 'Failed to find response of ID.');
        if($response->created_by != Auth::id()) return back()->with('error', 'Failed to find response of ID.');

        $test = \App\Models\Test::find($response->test_id);
        if(!$test) return back()->with('error', 'Failed to find the test of the response.');

        return view('user/assigned_tests/response', ['response'=>$response, 'test'=>$test]);
    }

    public function test_responses(Request $request) {
        $id = $request->input('test') ?: null;
        $responses = null;
        $test = \App\Models\Test::where('id', $id)->where('created_by', Auth::id())->count();
        if($id !== null && $test > 0) {
            $responses = \App\Models\Response::select('responses.*', 'users.username')
                ->leftJoin('users', 'users.id', '=', 'responses.created_by')
                ->where('test_id', $id)->get();
        }

        $tests_orm = \App\Models\Test::select('id', 'name')->where('created_by', Auth::id())->get();
        $tests = [];
        foreach($tests_orm as $test) $tests[$test->id] = $test->name;

        return view('user/test_responses', ['responses'=>$responses, 'id'=>$id, 'tests'=>$tests]);
    }
}
