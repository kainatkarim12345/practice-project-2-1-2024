<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        // dd(Auth::user());
        if(Auth::check() && Auth::user()->user_role_id == 1)
        {
            return $next($request);
        }
        else
        {
            Auth::logout();           
            $request->session()->flush();            
            return redirect("/");
        }
    }
}
