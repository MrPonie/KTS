<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if(!$request->expectsJson()) {
            if($request->is('admin/*') || $request->is('admin')) {
                return route('admin.login');
            }else if($request->is('teacher/*') || $request->is('teacher')) {
                return route('teacher.login');
            }else if($request->is('student/*') || $request->is('student')) {
                return route('student.login');
            }else {
                return route('home');
            }
        }else{
            return route('home');
        }
    }
}
