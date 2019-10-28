<?php

namespace App\Http\Middleware;

use Closure;

class CheckRoll
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
        if(!$request->user()->ismanager)
            return redirect('/');

        return $next($request);
    }
}
