<?php

namespace App\Http\Middleware;

use Closure;
use App\Permission_Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
//use Illuminate\Support\Facades\Auth;
use Auth;

class RegionMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        dd(Auth::user());
        $current_route =$request->getRequestUri();
    //    dd($current_route);

//        dd($request);
//  $current_permissions =$user->region->id;
//        dd($current_permissions);
//
//allowed = false
//
//foreach ( current_permissions as permssion )
//
//{
//    if current-route == permission
//    allowed = true
//
//}
//
//if (allowed) {
//    return next()
//} else {
//    redirect(permission-denied)
//}
        return $next($request);
    }
}
