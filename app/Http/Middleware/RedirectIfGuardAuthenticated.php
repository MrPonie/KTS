<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

class RedirectIfGuardAuthenticated
{
    /**
     * Default redirect routes for specified guards
     */
    private $guardRedirects = [
        'admin' => RouteServiceProvider::ADMIN_HOME,
        'teacher' => RouteServiceProvider::TEACHER_HOME,
        'student' => RouteServiceProvider::STUDENT_HOME,
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $guard, string $redirectTo=null): Response
    {
        if(Auth::guard($guard)->check()){
            if($redirectTo === null){
                if(array_key_exists($guard, $this->guardRedirects)){
                    return redirect($this->guardRedirects[$guard]);
                }
            }else{
                return redirect($redirectTo);
            }
        }

        return $next($request);
    }
}
