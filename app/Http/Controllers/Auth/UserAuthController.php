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
            return redirect()->intended('/user');
        }

        return back()->withErrors(['username'=>'Invalid credentials']);
    }

    public function logout() {
        Auth::logout();
        return redirect('/user/login');
    }
}