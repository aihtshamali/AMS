<?php

namespace App\Http\Middleware;

use Closure;
use App\Permission_Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
    use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
//use Auth;

class RegionMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

//        $object=Route::getRoutes();
//        $routes=(array) $object;
//        foreach ($routes as $key =>$value) {
//            if ($value == "login")
//                dd($value);
//            foreach ($value as $k => $v) {
//                if ($k == "login") {
//                    $a=(array)$value;
//                    dd($value);
//                }
//            }
//        }
        //$allRoutes = Route::getRoutes();
//    dd($//allRoutes);
//

//        $allowed = true;
//        if(Auth::check()) {
//            $user = Auth::user();
//            $current_route = Route::currentRouteName();
//            $allowed = false;
//            $current_permissions = Permission_Role::where('user_id', $user->id)->get();
//            foreach ($current_permissions as $userpermission) {
//
//                if ($current_route == $userpermission->permission->name) {
//                    $allowed = true;
//                }
//            }
//        }
//        if ($allowed) {
//            return $next($request);
//        }
//        else {
//            abort(403, 'Unauthorized action - You are not Authorized for this action');
//        }
         return $next($request);
    }
}
