<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckAdminLevel
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
		if(!Auth::check() || Auth::user()->level->name != 'Admin')
		{
			return redirect('/login');
		}
        return $next($request);
    }
}
