<?php
namespace Core\Base\Middlewares;
use Illuminate\Http\Request;
use Closure;

class Authorization {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $permission
     * @return mixed
     */
    public function handle($request, Closure $next, string $permission) 
    {
        if(!acl_check_login())
            return $this->handleUnauthorizedRequest();

        if(!acl_get_current_user()->hasPermission($permission))
        {
            return $this->handleUnauthorizedRequest();
        }

        return $next($request);
    }

    /**
     * @param Request $request
     * @param $permission
     * @return \Illuminate\Http\RedirectResponse|Response
     */
    protected function handleUnauthorizedRequest(Request $request, $permission)
    {
        if ($request->expectsJson()) {
            return response('Unauthorized.', Response::HTTP_UNAUTHORIZED);
        }
        if ($request->user() === null) {
            return $this->redirect->route(HOME_ROUTE_FRONTEND);
        }

        return $this->redirect->route(HOME_ROUTE_BACKEND);
    }
}