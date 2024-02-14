<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function dashboard() {
        return view('teacher/dashboard');
    }

    public function login() {
        return view('teacher/auth/login');
    }
}
