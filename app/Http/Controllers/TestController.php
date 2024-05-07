<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\support\Carbon;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function tests(Request $request) {
        $tests = \App\Models\Test::select('tests.id', 'tests.name', 'tests.is_active', 'tests.question_count', 'tests.max_points', 'tests.created_at', 'users.username as user', DB::raw('count(test__users.test_id) as student_count'))
            ->leftJoin('users', 'users.id', '=', 'tests.created_by')
            ->leftJoin('test__users', 'test__users.test_id', '=', 'tests.id')
            ->groupBy('tests.id', 'tests.name', 'tests.is_active', 'tests.question_count', 'tests.max_points', 'tests.created_at', 'users.username');
        // filters
        if($request->input('by') !== null) $tests = $tests->where('tests.created_by', '=', $request->input('by'));
        if($request->input('active') !== null) $tests = $tests->where('tests.is_active', '=', $request->input('active'));
        if($request->input('search') !== null) $tests = $tests->where('tests.name', 'like', '%'.$request->input('search').'%');
        // get filtered tests
        $tests = $tests->get();

        $teachers = [null=>'None'];
        foreach(\App\Models\User::select('id', 'username')->where('role_id', '=', 2)->get() as $user) $teachers[$user->id] = $user->username;

        return view('admin/tests', ['tests'=>$tests, 'teachers'=>$teachers]);
    }

    public function list(Request $request) {
        $tests = \App\Models\Test::select('tests.*', DB::raw('count(test__users.user_id) as user_count'), DB::raw('count(responses.id) as responses'))
            ->leftJoin('test__users', 'test__users.test_id', '=', 'tests.id')
            ->leftJoin('responses', 'responses.test_id', '=', 'tests.id')
            ->groupBy('tests.id', 'tests.created_by', 'tests.test_form_id', 'tests.name', 'tests.is_active', 'tests.content_json', 'tests.grading_json', 'tests.question_count', 'tests.max_points', 'tests.created_at', 'tests.updated_at');
        // filters
        if($request->input('active') !== null) $tests = $tests->where('tests.is_active', '=', $request->input('active'));
        if($request->input('search') !== null) $tests = $tests->where('tests.name', 'like', '%'.$request->input('search').'%');
        // get filtered tests
        $tests = $tests->get();
        return view('user/test_list/test_list', ['tests'=>$tests]);
    }

    public function assigned_tests(Request $request) {
        $tests = \App\Models\Test::select('tests.id', 'tests.name', 'tests.is_active', 'tests.question_count', 'tests.max_points')
            ->leftJoin('test__users', 'test__users.test_id', '=', 'tests.id')
            ->where('test__users.user_id', Auth::id());
        if($request->input('search') !== null) $tests = $tests->where('tests.name', 'like', '%'.$request->input('search').'%');
        $tests = $tests->get();
        $responses = [];
        foreach($tests as $test) {
            $responses[] = \App\Models\Response::select('id', 'points', 'grade')
                ->where('created_by', '=', Auth::id())
                ->where('test_id', '=', $test->id)
                ->get()->first();
        }
        return view('user/assigned_tests/assigned_tests', ['tests'=>$tests,'responses'=>$responses]);
    }

    public function undone_assigned_tests(Request $request) {
        $tests = \App\Models\Test::select('tests.id', 'tests.name', 'tests.is_active', 'tests.question_count', 'tests.max_points')
            ->leftJoin('test__users', 'test__users.test_id', '=', 'tests.id')
            ->where('test__users.user_id', Auth::id())
            ->whereRaw('(select count(*) from responses where responses.test_id = tests.id and responses.created_by = test__users.user_id) = 0')
            ->get();
        
        return view('user/assigned_tests/undone_assigned_tests', ['tests'=>$tests]);
    }

    public function create_view(Request $request) {
        return view('user/test_list/create_test');
    }

    public function create(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string',
            'groups' => 'required|array',
            'form' => 'required',
            'grading' => 'required|string',
        ]);

        $users = [];
        foreach($validated['groups'] as $group) {
            $u = \App\Models\Group_User::select('user_id')->where('group_id', '=', $group)->get();
            foreach($u as $uu) {$users[] = $uu->user_id;}
        }

        $form = \App\Models\Test_Form::find($validated['form']);
        if(!$form) return back()->with('error', 'Failed to find selected test form.');

        $cols = [
            'created_by' => Auth::id(),
            'test_form_id' => $form->id,
            'name' => $validated['title'],
            'is_active' => false,
            'content_json' => $form->questions_json,
            'grading_json' => $validated['grading'],
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

    public function repond_to_test_view(Request $request, int $id) {
        // check if user has responded to the test already
        $found = \App\Models\Response::where('test_id', $id)->where('created_by', Auth::id())->count();
        if($found > 0) return redirect(route('user.assigned_tests'))->with('warning', 'User has already done this test!');

        $found = \App\Models\Test::leftJoin('test__users', 'test__users.test_id', 'tests.id')
            ->where('tests.id', $id)
            ->where('test__users.user_id', Auth::id())
            ->count();
        if($found <= 0) return redirect(route('user.assigned_tests'))->with('error', 'Could not find the test.');

        // create a new response record that would be empty until submission
        $response = new \App\Models\Response;
        $response->created_by = Auth::id();
        $response->test_id = $id;
        $response->created_at = \Carbon\Carbon::now();
        $response->updated_at = \Carbon\Carbon::now();
        if(!$response->save()) return redirect(route('user.assigned_tests'))->with('error', 'Failed to prepare response record.');

        $test = \App\Models\Test::find($id);
        if(!$test) return redirect(route('user.assigned_tests'))->with('error', 'Could not find test of ID.');

        return view('user/assigned_tests/respond_to_test', ['test'=>$test, 'id'=>$id]);
    }

    public function repond_to_test(Request $request, int $id) {
        $validated = $request->validate([
            'answer' => 'required|array'
        ]);

        $test = \App\Models\Test::find($id);
        if(!$test) return back()->with('error', 'Failed to find test of ID.');

        $response = \App\Models\Response::where('created_by', Auth::id())
            ->where('test_id', $id)
            ->get()->first();
        if(!$response) return back()->with('error', 'Failed to find response record to fill.');

        $res = [];
        $points = 0;
        foreach($test->content_json as $index=>$test_question) {
            if(isset($validated['answer'][$index])) {
                $answer = $validated['answer'][$index];
                $test_question_answer = $test->content_json[$index]['type']==1 ? json_decode($test->content_json[$index]['answer_json']) : $test->content_json[$index]['answer_json'];
                $res[] = (object)[
                    'answer' => $answer,
                    'correct' => $answer == $test_question_answer,
                ];
                if($answer == $test_question_answer) {
                    $points += $test->content_json[$index]['points'];
                }
            }else{
                $res[] = (object)[
                    'answer' => null,
                    'correct' => false,
                ];
            }
        }
        // foreach($validated['answer'] as $index=>$answer) {
        //     $test_question_answer = $test->content_json[$index]['type']==1 ? json_decode($test->content_json[$index]['answer_json']) : $test->content_json[$index]['answer_json'];
        //     $res[] = (object)[
        //         'answer' => $answer,
        //         'correct' => $answer == $test_question_answer,
        //     ];
        //     if($answer == $test_question_answer) {
        //         $points += $test->content_json[$index]['points'];
        //     }
        // }

        $grade = '';
        $passed = false;
        $perc = $points / $test->max_points * 100;
        $grades = json_decode($test->grading_json);
        $perc_diff_min = PHP_INT_MAX;
        foreach(json_decode($test->grading_json) as $g) {
            $diff = abs($g->percent - $perc);
            if($diff < $perc_diff_min) {
                $perc_diff_min = $diff;
                $grade = $g->grade;
                $passed = $g->pass;
            }
        }

        $response->response_json = $res;
        $response->points = $points;
        $response->grade = $grade;
        $response->passed = $passed;
        $response->updated_at = \Carbon\Carbon::now();

        if(!$response->save()) return back()->with('error', 'Failed to save response.');

        return redirect(route('user.view_results', $response->id));
    }
}
