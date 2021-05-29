<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        /*if (Auth::guard($guard)->check()) {
            return redirect('/home');
        }*/
        if (Auth::guard($guard)->check()) {
         //echo "->".Auth::user()->role_id;die;
         if(Auth::user()->role_id==1){
           return redirect('/dashboard');
         }else if(Auth::user()->role_id==2){
           return redirect('/salesdashboard');
         }else if(Auth::user()->role_id==3){
           return redirect('/kitchendashboard');
         }else if(Auth::user()->role_id==4){
           return redirect('/counterdashboard');
         }else{
           return redirect('/')->with('message','You have to no access of login page.');
         }
       }

        return $next($request);
    }
}
