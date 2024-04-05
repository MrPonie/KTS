<?php 

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class UserAuthController extends Controller {
    public function login(Request $request) {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        
        $credentials = ['username' => $request->input('username'), 'password' => $request->input('password')];

        // check if user exists and is active
        if(\App\Models\User::where('username', '=', $request->input('username'))->where('is_active', '=', true)->count() != 0) {

            // authenticate user
            if(Auth::attempt($credentials)){
                $user = Auth::user();
                
                // update last login datetime
                $user->last_login_at = \Carbon\Carbon::now();
                $user->is_online = true;
                $user->save();

                // load user role with permissions into session
                $role_columns = \App\Models\Role::select('name', 'permissions_json')->where('id', $user->role_id)->first();
                $role = [
                    'id' => $user->role_id,
                    'name' => $role_columns->name,
                    'permissions' => json_decode($role_columns->permissions_json),
                ];
                $request->session()->forget('role');
                $request->session()->put('role', $role);
                // load username to session
                $request->session()->forget('username');
                $request->session()->put('username', $user->username);
    
                return redirect()->intended('/user');
            }
        }

        return back()->withErrors(['top'=>'Invalid credentials']);
    }

    public function logout(Request $request) {
        $user = Auth::user();
        $user->is_online = false;
        $user->save();
        Auth::logout();
        $request->session()->flush();
        return redirect('/user/login');
    }
}