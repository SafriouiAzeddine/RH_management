<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRH
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check())
        {
        if(Auth::user()->role=='1'){
            return $next($request);//if admin then redirect me to the dashbord admin =$request
        }
        else
        {
            return redirect('/login')->with('status','Access denied ! as you are not admin');//else redirect me to the /home with warning message
        }
    }
        else
        {
            return redirect('/login')->with('status','Please Login first');
        }
    }
}
