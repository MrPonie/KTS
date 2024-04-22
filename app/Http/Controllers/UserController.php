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
    public function dashboard() {return view('user/dashboard');}

    public function profile() {
        $groups = \App\Models\Group::select()->leftJoin('group__users', 'group__users.group_id', '=', 'groups.id')->where('group__users.user_id', '=', Auth::id())->get();
        return view('user/profile', ['groups'=>$groups]);
    }

    public function login() {return view('user/login');}

    public function users() {
        $users = DB::table('users as u')
            ->select(DB::raw('u.id, u.username, u.role_id, r.name, u.is_online, u.is_active, u.last_login_at, u1.username as created_by, u.created_at, u.updated_at'))
            ->leftJoin('roles as r', 'u.role_id', '=', 'r.id')
            ->leftJoin('users as u1', 'u.created_by', '=', 'u1.id')
            ->get();
        
        return view('admin/users/users')->with(['users'=>$users]);
    }

    public function assign_view(Request $request, int $id) {
        return view('admin/users/assign_users');
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

    public function tests() {return view('admin/tests');}

    public function responses() {return view('admin/responses');}

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