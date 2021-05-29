<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\User;

class RedirectIFNotAdmin
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
        //  echo "Admin if middleware - ".Auth::user();die;
        if(Auth::user()){
          if(Auth::user()->role_id!=1){
            return redirect()->guest('/login');
          }
        }else{
          return redirect()->guest('/login');
        }
        return $next($request);
    }
}
