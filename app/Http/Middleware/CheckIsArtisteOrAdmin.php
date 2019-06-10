<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

class CheckIsArtisteOrAdmin
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
        $user = Auth::user();
        if (
            ! ($user->isAdmin ||
            $user->isArtiste)
            ) {
            throw new AuthorizationException('you are not an artiste or an admin');
        }

        return $next($request);
    }
}
