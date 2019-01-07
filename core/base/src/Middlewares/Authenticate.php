<?php

namespace Core\Base\Middlewares;

use Illuminate\Auth\Middleware\Authenticate as LaravelCoreAuthenticate;
use Closure;
use DashboardMenu;

class Authenticate extends LaravelCoreAuthenticate
{
    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate(array $guards)
    {
        parent::authenticate($guards);
        DashboardMenu::loadRegisterMenus();
        return DashboardMenu::init(request()->user());
    }
}
