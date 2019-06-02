<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Access\AuthorizationException;
use Closure;
use Illuminate\Support\Facades\Auth;
class CheckIsArtiste
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
        if(!(Auth::user()->isArtiste)) {
            throw new AuthorizationException("you are not an artiste");
        }
        return $next($request);
    }
}
