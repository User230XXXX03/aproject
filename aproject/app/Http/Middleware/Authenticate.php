<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    /**
     * authentication
     * @param $request
     * @param Closure $next
     * @param ...$guards
     */
    public function handle($request, \Closure $next, ...$guards)
    {
        //Verify login
        if (!session('user')) {
            //Check if there is an ajax request
            if ($request->ajax() || $request->wantsJson()) {
                //Interface returns 401
                return response('Unauthorized.', 401);
            } else {
                //Page Access Jump Routing
                return redirect()->guest('login');
            }
        }

        return $next($request);
    }
}
