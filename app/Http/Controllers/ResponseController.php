<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\support\Carbon;
use Illuminate\Support\Facades\DB;

class ResponseController extends Controller
{
    public function responses() {
        $responses = \App\Models\Response::select('responses.*', 'tests.name', 'users.username')
            ->leftJoin('users', 'users.id', 'responses.created_by')
            ->leftJoin('tests', 'tests.id', 'responses.test_id')
            ->get();
        return view('admin/responses', compact('responses'));
    }

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
        $test = \App\Models\Test::where('id', $id)->where('created_by', Auth::id())->get()->first();
        if($id !== null && $test) {
            $responses = \App\Models\Response::select('responses.*', 'users.username')
                ->leftJoin('users', 'users.id', '=', 'responses.created_by')
                ->where('test_id', $id)->get();
        }

        $tests_orm = \App\Models\Test::select('id', 'name')->where('created_by', Auth::id())->get();
        $tests = [];
        foreach($tests_orm as $t) $tests[$t->id] = $t->name;

        // response analysis data
        $min = $max = $range = $mean = $median = $std_deviation = null;
        $test_question_analysis_data = null;
        $responses_count = $responses ? count($responses) : null;
        if($responses !== null && !$responses->isEmpty()){
            // create responses points array for easier calculation and start calculating values
            $points = [];
            foreach($responses as $response) {
                if($min===null || $response->points < $min) $min = $response->points;
                if($max===null || $response->points > $max) $max = $response->points;
                $points[] = $response->points;
            }
            $range = $max - $min;
            // mean and median
            if(count($points) > 0) {
                $mean = count($points) > 0 ? array_sum($points) / count($points) : null;
                sort($points);
                if(count($points)%2 == 0 && count($points) > 0) $median = ($points[count($points)-1] + $points[count($points)-2]) / 2;
                else $median = $points[count($points) / 2];
            }
            // std deviation
            if(count($points) > 1){
                $square_sum = 0;
                foreach($points as $point) $square_sum = ($point - $mean) ** 2;
                $std_deviation = sqrt($square_sum / (count($points)-1));
            }

            // test per question analysis data
            $test_question_analysis_data = $test->content_json;
            foreach($test_question_analysis_data as &$question) {
                $input = json_decode($question['input_json']);
                foreach($input ?: [] as $in) {
                    $in->selected = 0;
                }
                $question['input_json'] = $input;
            }
            foreach($responses as $response) {
                foreach($response->response_json as $index=>$question_response){
                    foreach($test_question_analysis_data[$index]['input_json'] ?: [] as $test_question_option) {
                        if(is_array($question_response['answer'])) {
                            if(in_array($test_question_option->id, $question_response['answer'])) $test_question_option->selected += 1;
                        }
                        else {
                            if($test_question_option->id == $question_response['answer']) $test_question_option->selected += 1;
                        }
                    }
                }
            }
        }

        return view('user/test_responses', compact(
            'id', 'responses', 'tests', 'min', 'max', 'range', 'mean', 'median', 'std_deviation', 'test_question_analysis_data', 'responses_count'
        ));
    }

    public function test_response(Request $request, int $id) {
        $response = \App\Models\Response::find($id);

        if(!$response) return back()->with('error', 'Response not found.');

        $test = \App\Models\Test::where('id', $response->test_id)->where('created_by', Auth::id())->get()->first();

        if(!$test) return back()->with('error', 'Response not found.');

        $user = \App\Models\User::find($response->created_by);

        return view('user/test_response', compact('response', 'test', 'user', 'id'));
    }

    public function edit_test_response(Request $request, int $id, int $qid, int $status) {
        // return back()->with('error', json_encode([$id, $qid, $status]));
        dd('test');
    }
}
