<?php

namespace App\Http\Middleware;

use Closure;

class AddUserId
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
        $user = $request->user();
        $userId = $user ? ['user_id' => $user->id] : [];
        $request->merge($userId);
        return $next($request);
    }
}
