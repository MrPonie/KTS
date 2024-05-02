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

    public function test_responses(Request $request, ?int $id) {
        $responses = null;
        $test = \App\Models\Test::where('id', $id)->where('created_by', Auth::id())->count();
        if($id !== null && $test > 0) {
            $responses = \App\Models\Response::where('test_id', $id)->get();
        }

        return view('user/test_responses', ['responses'=>$responses, 'id'=>$id]);
    }
}
