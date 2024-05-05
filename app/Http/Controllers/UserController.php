<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\support\Carbon;
use App;

class UserController extends Controller
{
    public function dashboard() {
        $data = [];

        if($permissions = session('role')['permissions']) {
            // student
            if($permissions->can_receive_tests) {
                $data['assigned_tests'] = \App\Models\Test::leftJoin('test__users', 'test__users.test_id', '=', 'tests.id')->where('test__users.user_id', Auth::id())->count();
                $data['answered_assigned_tests'] = \App\Models\Test::select('tests.id', 'tests.name', 'tests.is_active', 'tests.question_count', 'tests.max_points')
                    ->leftJoin('test__users', 'test__users.test_id', '=', 'tests.id')
                    ->where('test__users.user_id', Auth::id())
                    ->whereRaw('(select count(*) from responses where responses.test_id = tests.id and responses.created_by = test__users.user_id) > 0')
                    ->count();
                $data['unanswered_assigned_tests'] = $data['assigned_tests'] - $data['answered_assigned_tests'];
            }
            // teacher
            if($permissions->has_question_bank) {
                $data['question_bank_questions'] = \App\Models\Question::where('created_by', Auth::id())->count();
                $data['question_bank_topics'] = \App\Models\Topic::where('created_by', Auth::id())->count();
            }
            if($permissions->has_test_form_vault) {
                $data['test_form_vault_forms'] = \App\Models\Test_Form::where('created_by', Auth::id())->count();
                $data['test_form_vault_forms_used'] = \App\Models\Test_Form::whereRaw('(select count(*) from tests where tests.test_form_id = test__forms.id) > 0')->where('created_by', Auth::id())->distinct()->count();
            }
            if($permissions->has_tests_list) {
                $data['test_list_active'] = \App\Models\Test::where('tests.created_by', Auth::id())->where('is_active', true)->count();
                $data['test_list_inactive'] = \App\Models\Test::where('tests.created_by', Auth::id())->where('is_active', false)->count();
                $data['test_list_tests'] = \App\Models\Test::where('tests.created_by', Auth::id())->count();
                $data['received_responses'] = \App\Models\Response::leftJoin('tests', 'tests.id', 'responses.test_id')->where('tests.created_by', Auth::id())->count();
            }
            // administrator
            if($permissions->view_users) {
                $data['users'] = \App\Models\User::count();
                $data['users_active'] = \App\Models\User::where('is_active', true)->count();
                $data['users_inactive'] = \App\Models\User::where('is_active', false)->count();
                $data['users_online'] = \App\Models\User::where('is_online', true)->count();
            }
            if($permissions->view_questions) {
                $data['questions'] = \App\Models\Question::count();
            }
            if($permissions->view_test_forms) {
                $data['test_forms'] = \App\Models\Test_Form::count();
            }
            if($permissions->view_tests) {
                $data['tests'] = \App\Models\Test::count();
                $data['test_active'] = \App\Models\Test::where('is_active', true)->count();
                $data['test_inactive'] = \App\Models\Test::where('is_active', false)->count();
            }
            if($permissions->view_responses) {
                $data['responses'] = \App\Models\Response::count();
            }
        }

        return view('user/dashboard', $data);
    }

    public function profile() {
        $groups = \App\Models\Group::select()->leftJoin('group__users', 'group__users.group_id', '=', 'groups.id')->where('group__users.user_id', '=', Auth::id())->get();
        return view('user/profile', ['groups'=>$groups]);
    }

    public function login() {return view('user/login');}

    public function users(Request $request) {
        $users = DB::table('users as u')
            ->select(DB::raw('u.id, u.username, u.role_id, r.name, u.is_online, u.is_active, u.last_login_at, u1.username as created_by, u.created_at, u.updated_at'))
            ->leftJoin('roles as r', 'u.role_id', '=', 'r.id')
            ->leftJoin('users as u1', 'u.created_by', '=', 'u1.id')
            ->leftJoin('group__users as gu', 'gu.user_id', '=', 'u.id');
        // filters
        if($request->input('role') !== null) $users = $users->where('u.role_id', '=', $request->input('role'));
        if($request->input('group') !== null) $users = $users->where('gu.group_id', '=', $request->input('group'));
        if($request->input('by') !== null) $users = $users->where('u.created_by', '=', $request->input('by'));
        if($request->input('active') !== null) $users = $users->where('u.is_active', '=', $request->input('active'));
        if($request->input('search') !== null) $users = $users->where('u.username', 'like', '%'.$request->input('search').'%');
        // get filtered users
        $users = $users->get();

        $groups = [];
        foreach($users as $user) {
            $user_groups = \App\Models\Group_User::select('groups.name')
                ->leftJoin('groups', 'groups.id', '=', 'group__users.group_id')
                ->where('group__users.user_id', '=', $user->id)
                ->get();
            $g = [];
            foreach($user_groups as $ug) $g[] = $ug->name;
            $groups[] = $g;
        }

        $all_groups = [null=>'None'];
        foreach(\App\Models\Group::select('id', 'name')->get() as $group) $all_groups[$group->id] = $group->name;

        $admins = [null=>'None'];
        foreach(\App\Models\User::select('id', 'username')->where('role_id', '=', 1)->get() as $user) $admins[$user->id] = $user->username;

        return view('admin/users/users')->with(['users'=>$users, 'groups'=>$groups, 'all_groups'=>$all_groups, 'admins'=>$admins]);
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

        return back()->with('error', 'Failed to '.($status ? 'activate' : 'deactivate').' user account.');
    }

    public function edit_view(int $id) {
        $user = \App\Models\User::select('username', 'is_active', 'role_id')->where('id', '=', $id)->get();
        $groups = \App\Models\Group::select('groups.id', 'groups.name')->leftJoin('group__users', 'group__users.group_id', '=', 'groups.id')->where('group__users.user_id', '=', $id)->get();
        $groups_arr = [];
        foreach($groups as $group) {
            $groups_arr[] = (object)['id'=>$group->id, 'name'=>$group->name];
        }
        $roles = [];
        foreach(\App\Models\Role::select('id', 'name')->get() as $role){
            $roles[$role->id] = $role->name;
        }
        if($user){
            return view('admin/users/edit_user')->with(['user'=>$user[0], 'roles'=>$roles, 'list'=>$groups_arr]);
        }else{
            return back()->with('error', 'Could not get user data.');
        }
    }

    public function edit(Request $request, int $id) {
        // validate
        $validated = $request->validate([
            'is_active' => 'sometimes',
            'role' => 'required|integer',
            'password' => 'sometimes',
            'retype_password' => 'required_with:password',
            'groups' => 'sometimes|array',
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

            // I know I should not do this, but I just don't care anymore...
            \App\Models\Group_User::where('user_id', '=', $id)->delete();
            if(isset($validated['groups'])) {                
                foreach($validated['groups'] as $group) {
                    $record = new \App\Models\Group_User;
                    $record->group_id = $group;
                    $record->user_id = $id;
                    $record->created_at = \Carbon\Carbon::now();
                    $record->updated_at = \Carbon\Carbon::now();
                    $record->save();
                }
            }

            if($user->save()) {
                return back()->with('success', 'Successfuly updated user.');
            }
        }

        return back()->with('error', 'Failed to update user.');
    }

    public function create_view() {
        $roles_db = \App\Models\Role::select('id', 'name')->get();
        $roles = [];
        foreach($roles_db as $role){
            $roles[$role->id] = $role->name;
        }
        return view('admin/users/create_new_user')->with(['roles'=>$roles]);
    }

    public function create(Request $request) {
        $validated = $request->validate([
            'username' => 'required|unique:users|max:255',
            'password' => 'required',
            'retype_password' => 'required',
            'role' => 'required',
            'is_active' => 'sometimes',
            'groups' => 'sometimes|array',
        ]);

        if($validated['password'] !== $validated['retype_password']){
            return back()->withErrors(['retype_password' => 'Passwords did not match.']);
        }

        $user = \App\Models\User::create([
            'created_by' => Auth::id(),
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role'],
            'created_at' => \Carbon\Carbon::now(),
            'is_active' => isset($validated['is_active']) ? true : false,
        ]);

        if(!$user) {return back()->with('error', 'Failed to create a new user.');}

        if(isset($validated['groups'])) {
            foreach($validated['groups'] as $group) {
                $group_user = new \App\Models\Group_User;
                $group_user->group_id = $group;
                $group_user->user_id = $user->id;
                $group_user->created_at = \Carbon\Carbon::now();
                $group_user->updated_at = \Carbon\Carbon::now();
                $group_user->save();
            }
        }

        return back()->with('success', 'New user created!');
    }
}