<?php

namespace Beam\Http\Middleware;

use Closure;
use Beam\Contracts\Auth\CanActivateAccount;

class RedirectIfUnactivated
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
        if (Auth::guard($guard)->check() && Auth::guard($guard)->user() instanceof CanActivateAccount) {
            if (!Auth::guard($guard)->user()->active) {
                return redirect(config('redirect_when_unactive', '/home'));
            }
        }

        return $next($request);
    }
}
