<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperUser
{

    public function handle(Request $request, Closure $next)
    {
        if(!Auth::user()->is_superuser) {
            return route('home');
        }
        return $next($request);
    }
}
