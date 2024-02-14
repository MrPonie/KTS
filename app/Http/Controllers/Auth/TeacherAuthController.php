<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class TeacherAuthController extends Controller
{
    public function login(Request $request) {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        
        $credentials = ['username' => $request->input('username'), 'password' => $request->input('password')];

        if(Auth::guard('teacher')->attempt($credentials)){
            return redirect()->intended(RouteServiceProvider::STUDENT_HOME);
        }

        return back()->withErrors(['username'=>'Invalid credentials']);
    }

    public function logout() {
        Auth::guard('teacher')->logout();
        return redirect('/teacher/login');
    }
}
