<?php 

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministratorAuthController extends Controller {
    public function login(Request $request) {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        
        $credentials = ['username' => $request->input('username'), 'password' => $request->input('password')];

        if(Auth::guard('admin')->attempt($credentials)){
            return redirect()->intended('/admin');
        }

        return back()->withErrors(['username'=>'Invalid credentials']);
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}