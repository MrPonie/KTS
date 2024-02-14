<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard() {
        return view('student/dashboard');
    }

    public function login() {
        return view('student/auth/login');
    }
}
