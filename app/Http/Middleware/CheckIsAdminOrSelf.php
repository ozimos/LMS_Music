<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

class CheckIsAdminOrSelf
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
        $requestedUserId = $request->route()->parameter('user');
        $user = Auth::user();
        if (
            ! ($user->isAdmin ||
            ($user->id == $requestedUserId))
        ) {
            throw new AuthorizationException('you do not have admin permissions or are not the oner of this resource');
        }

        return $next($request);
    }
}
