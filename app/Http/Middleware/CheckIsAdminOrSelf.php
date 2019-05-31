<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

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

        if(
            Auth::user()->isAdmin ||
            Auth::id() == $requestedUserId
        ) {
            return $next($request);
        }
        else {
            return response()->json( ['error' => 'UnAuthorized'], 403);
        }
    }
}
