<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionCheck
{
    /**
     * Gets permissions to confirm and aborts with code 404 if any one of given permissions were not found or given
     * When using it is a must that at least one permission argument is passed to midleware
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$permissions  permissions to check
     * 
     */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        $is_permitted = false;

        if($session_permissions = session('role')['permissions']){
            $is_permitted = true;
            foreach($permissions as $permission) {
                if (property_exists($session_permissions, $permission)){
                    if ($session_permissions->$permission !== true) {
                        $is_permitted = false;
                        break;
                    }
                } else {
                    $is_permitted = false;
                    break;
                }
            }
        }

        if(!$is_permitted){
            abort(404);
        }

        return $next($request);
    }
}
