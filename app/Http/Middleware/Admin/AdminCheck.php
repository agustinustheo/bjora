<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminCheck
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
        //middleware to check role of logged in user
        // 1 = admin
        if (Auth::check()) {
            if(Auth::user()->role == 1) {
                return $next($request);
            }
            return redirect()->back();
        }
        return redirect()->back();
    }
}
