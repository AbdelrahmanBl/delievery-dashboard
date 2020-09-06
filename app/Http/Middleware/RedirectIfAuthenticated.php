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
        switch ($guard) {
            case 'main':
                if (Auth::guard('admin')->check()) 
                    return redirect('/dashboard');
                else if(Auth::guard('fleet')->check())
                    return redirect('/dashboardF');
                break;
            case 'admin':
                if (!Auth::guard('admin')->check()) 
                    return redirect('/login');
                break;
            case 'fleet':
                if(!Auth::guard('fleet')->check())
                    return redirect('/login');
                break;     
        }
        return $next($request);
        
    }
}
