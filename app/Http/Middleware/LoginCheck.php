<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoginCheck
{

    public function handle(Request $request, Closure $next)
    {
        if (session()->has("isLoged")) {
            return $next($request);
        } else {
            return redirect('/login');
        }
    }
}
