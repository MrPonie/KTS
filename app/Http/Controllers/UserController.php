<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App;

class UserController extends Controller
{
    public function dashboard() {return view('user/dashboard');}

    public function profile() {return view('user/profile');}

    public function login() {return view('user/login');}

    public function users() {
        $users = \App\Models\User::select('users.id', 'users.username', 'roles.name', 'users.is_online', 'users.is_active', 'users.last_login_at', 'users.created_by', 'users.created_at')->leftJoin('roles', 'users.role_id', '=', 'roles.id')->get();
        return view('admin/users/users')->with(['users'=>$users]);
    }

    public function change_user_active_status(Request $request, bool $status) {
        $validator = Validator::make($request->all(), ['id' => 'required|integer']);

        if(!$validator->fails()){
            $validated = $validator->validated();

            if($user = \App\Models\User::find($validated['id'])){
                $user->is_active = $status;
                if($user->save()) {
                    return redirect()->back()->with('success', 'Successfuly '.($status ? 'activated' : 'deactivated').' user account.');
                }
            }
        }

        return redirect()->back()->with('error', 'Failed to '.($status ? 'activate' : 'deactivate').' user account.');
    }

    public function edit_user_view(int $id) {
        $user = \App\Models\User::select('username', 'is_active', 'role_id')->where('id', '=', $id)->get();
        $roles = [];
        foreach(\App\Models\Role::select('id', 'name')->get() as $role){
            $roles[$role->id] = $role->name;
        }
        if($user){
            return view('admin/users/edit_user')->with(['user'=>$user[0], 'roles'=>$roles]);
        }else{
            return redirect()->back()->with('error', 'Could not get user data.');
        }
    }

    public function edit_user(Request $request, int $id) {
        // validate
        $validated = $request->validate([
            'is_active' => 'sometimes',
            'role' => 'required|integer',
            'password' => 'sometimes',
            'retype_password' => 'required_with:password'
        ]);

        // get user
        $user = \App\Models\User::find($id);
        if($user) {
            // update user
            $user->is_active = isset($validated['is_active']);
            $user->role_id = $validated['role'];
            if(isset($validated['password'])){
                if($validated['password'] === $validated['retype_password']) {
                    $user->password = Hash::make($validated['password']);
                } else {
                    return back()->withErrors(['retype_password' => 'Passwords did not match.']);
                }
            }

            if($user->save()) {
                return back()->with('success', 'Successfuly updated user.');
            }
        }

        return back()->with('error', 'Failed to update user.');
    }

    public function create_new_user_view() {
        $roles_db = \App\Models\Role::select('id', 'name')->get();
        $roles = [];
        foreach($roles_db as $role){
            $roles[$role->id] = $role->name;
        }
        return view('admin/users/create_new_user')->with(['roles'=>$roles]);
    }

    public function create_new_user(Request $request) {
        $validated = $request->validate([
            'username' => 'required|unique:users|max:255',
            'password' => 'required',
            'retype_password' => 'required',
            'role' => 'required',
            'is_active' => 'sometimes',
        ]);

        if($validated['password'] !== $validated['retype_password']){
            return redirect()->back()->withErrors(['retype_password' => 'Passwords did not match.']);
        }

        $user = new \App\Models\User;
        $user->username = $validated['username'];
        $user->password = Hash::make($validated['password']);
        $user->role_id  = $validated['role'];
        $user->is_active = isset($validated['is_active']) ? true : false;
        
        if($user->save()){
            return redirect()->route('users.create_new_user')->with('success', 'New user created!');
        }else{
            return redirect()->route('users.create_new_user')->with('error', 'Failed to create a new user.');
        }
    }

    public function questions() {return view('admin/questions');}
    public function topics() {return view('admin/topics');}

    public function test_forms() {return view('admin/test_forms');}

    public function tests() {return view('admin/tests');}

    public function responses() {return view('admin/responses');}

    public function question_bank() {return view('user/question_bank/question_bank');}
    public function question_bank_topics() {return view('user/question_bank/question_bank_topics');}
    public function create_new_question_view() {return view('user/question_bank/create_new_question');}
    public function create_new_question() {

    }
    public function create_new_topic_view() {return view('user/question_bank/create_new_topic');}
    public function create_new_topic() {

    }

    public function test_form_vault() {return view('user/test_form_vault/test_form_vault');}
    public function create_new_test_form_view() {return view('user/test_form_vault/create_new_test_form');}
    public function create_new_test_form() {

    }
    public function export_test_form_view() {return view('user/test_form_vault/export_test_form');}
    public function export_test_form() {
        
    }

    public function test_list() {return view('user/test_list/test_list');}
    public function create_test_view() {return view('user/test_list/create_test');}
    public function create_test() {
        
    }

    public function assigned_tests() {return view('user/assigned_tests/assigned_tests');}
    public function undone_assigned_tests() {return view('user/assigned_tests/undone_assigned_tests');}
    public function repond_to_test_view() {return view('user/assigned_tests/respond_to_test');}
    public function repond_to_test() {

    }
}
