<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checksigned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(session()->get('user'))
            return $next($request);
        else
            return redirect('/public/signin')->withErrors('You need to sign in to access the contents!');
    }
}
