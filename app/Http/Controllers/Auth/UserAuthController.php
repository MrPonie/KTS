<?php 

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller {
    public function login(Request $request) {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        
        $credentials = ['username' => $request->input('username'), 'password' => $request->input('password')];

        if(Auth::attempt($credentials)){
            // load user role with permissions into session
            $role_columns = \App\Models\Role::select('name', 'permissions_json')->where('id', Auth::user()->role_id)->first();
            $role = [
                'id' => Auth::user()->role_id,
                'name' => $role_columns->name,
                'permissions' => json_decode($role_columns->permissions_json),
            ];
            $request->session()->forget('role');
            $request->session()->put('role', $role);
            // load username to session
            $request->session()->forget('username');
            $request->session()->put('username', Auth::user()->username);

            return redirect()->intended('/user');
        }

        return back()->withErrors(['username'=>'Invalid credentials']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->flush();
        return redirect('/user/login');
    }
}