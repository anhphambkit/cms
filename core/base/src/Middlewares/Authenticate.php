<?php

namespace Core\Base\Middlewares;

use Illuminate\Auth\Middleware\Authenticate as LaravelCoreAuthenticate;
use Closure;
use DashboardMenu;

class Authenticate extends LaravelCoreAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure $next
     * @param array $guards
     * @return mixed
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = $this->authenticate($guards);
        return $next($request);
    }
}
