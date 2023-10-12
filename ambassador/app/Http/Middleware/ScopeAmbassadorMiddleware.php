<?php

namespace App\Http\Middleware;

use Closure;
use DiKay\UserService;
use Illuminate\Http\Request;

class ScopeAmbassadorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        (new UserService(config('microservices.user')))->get('scope/ambassador');

        return $next($request);
    }
}
