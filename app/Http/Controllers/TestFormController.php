<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\support\Carbon;
use Illuminate\Support\Facades\DB;

class TestFormController extends Controller
{
    public function test_forms(Request $request) {
        $forms = \App\Models\Test_Form::select('test__forms.id', 'test__forms.name', 'test__forms.description', 'test__forms.question_count', 'test__forms.max_points', 'test__forms.created_at', 'test__forms.updated_at', 'users.username as user')
            ->leftJoin('users', 'users.id', '=', 'test__forms.created_by');
        // filters
        if($request->input('by') !== null) $forms = $forms->where('test__forms.created_by', '=', $request->input('by'));
        if($request->input('search') !== null) $forms = $forms->where('test__forms.name', 'like', '%'.$request->input('search').'%');
        // get filtered forms
        $forms = $forms->get();

        $teachers = [null=>'None'];
        foreach(\App\Models\User::select('id', 'username')->where('role_id', '=', 2)->get() as $user) $teachers[$user->id] = $user->username;

        return view('admin/test_forms', ['forms'=>$forms, 'teachers'=>$teachers]);
    }

    public function vault(Request $request) {
        $forms = \App\Models\Test_Form::select('id', 'name', 'description', 'question_count', 'max_points', 'created_at', 'updated_at')->where('created_by', '=', Auth::id());
        if($request->input('search') != '') {
            $forms = $forms->where('name', 'like', '%'.$request->input('search').'%');
        }
        $forms = $forms->get();
        return view('user/test_form_vault/test_form_vault', ['test_forms' => $forms]);
    }

    public function create_view() {return view('user/test_form_vault/create_new_test_form');}
    
    public function create(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'sometimes',
            'questions' => 'required|string',
        ]);

        $question_arr = [];
        $max_points = 0;

        $questions = json_decode(htmlspecialchars_decode($validated['questions']));
        if($questions) {
            foreach($questions as $question) {
                $record = \App\Models\Question::find($question->id);
                $item = (object)[];
                $item->id = $question->id;
                $item->topic = $question->topic;
                $item->type = $record->type;
                $item->evaluable = $record->evaluable;
                $item->points = $question->points;
                $item->question = $record->question;
                $item->input_json = $record->input_json;
                $item->answer_json = $record->answer_json;
                $question_arr[] = $item;
                $max_points += $record->points;
            }
        }else{
            return back()->with('error', 'Failed to get test form questions.');    
        }

        $form = new \App\Models\Test_Form;
        $form->created_by = Auth::id();
        $form->name = $validated['title'];
        $form->description = isset($validated['description']) ? (is_string($validated['description']) ? $validated['description'] : '') : '';
        $form->questions_json = $question_arr;
        $form->question_count = count($question_arr);
        $form->max_points = $max_points;
        $form->created_at = \Carbon\Carbon::now();
        $form->updated_at = \Carbon\Carbon::now();

        if($form->save()) {
            return back()->with('success', 'Successfuly created a new Test Form!');
        }

        return back()->with('error', 'Failed to create a new Test Form');
    }

    public function edit_view(int $id) {
        $form = \App\Models\Test_Form::find($id);
        return view('user/test_form_vault/edit_test_form', ['form' => $form]);
    }

    public function edit(Request $request) {
        $validated = $request->validate([
            'id' => 'required|integer',
            'title' => 'required|string',
            'description' => 'sometimes',
            'questions' => 'required|string',
        ]);

        $question_arr = [];
        $max_points = 0;

        $questions = json_decode(htmlspecialchars_decode($validated['questions']));
        if($questions) {
            foreach($questions as $question) {
                $record = \App\Models\Question::find($question->id);
                $item = (object)[];
                $item->id = $question->id;
                $item->topic = $question->topic;
                $item->type = $record->type;
                $item->evaluable = $record->evaluable;
                $item->points = $question->points;
                $item->question = $record->question;
                $item->input_json = $record->input_json;
                $item->answer_json = $record->answer_json;
                $question_arr[] = $item;
                $max_points += $record->points;
            }
        }else{
            return back()->with('error', 'Failed to get test form questions.');
        }

        $form = \App\Models\Test_Form::find($validated['id']);
        if(!$form) return back()->with('error', 'Failed to find Test Form of ID.');
        $form->created_by = Auth::id();
        $form->name = $validated['title'];
        $form->description = isset($validated['description']) ? (is_string($validated['description']) ? $validated['description'] : '') : '';
        $form->questions_json = $question_arr;
        $form->question_count = count($question_arr);
        $form->max_points = $max_points;
        $form->updated_at = \Carbon\Carbon::now();

        if($form->save()) {
            return back()->with('success', 'Successfuly updated the Test Form!');
        }

        return back()->with('error', 'Failed to update the Test Form.');
    }

    public function export_view() {return view('user/test_form_vault/export_test_form');}

    public function export(Request $request) {
        return back()->with('error', 'todo');
    }

    public function delete(Request $request, int $id) {
        $form = \App\Models\Test_Form::find($id);
        if(!$form) return back()->with('error', 'Failed to find test form of the ID.');
        $form->delete();
        return back()->with('success', 'Successfuly delete the test form.');
    }
}
