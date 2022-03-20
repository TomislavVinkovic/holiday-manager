<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotSuperuser
{
    //some views, like vacation request views, should not be viewed by admins, as
    //described in the task
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->is_superuser) {
            return redirect(route('home'));
        }
        return $next($request);
    }
}
