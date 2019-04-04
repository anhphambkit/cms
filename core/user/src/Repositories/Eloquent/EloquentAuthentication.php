<?php

namespace Core\User\Repositories\Eloquent;

use Core\User\Events\UserHasActivatedAccount;

class EloquentAuthentication implements \Core\User\Repositories\Interfaces\Authentication
{
    /**
     * Authenticate a user
     * @param  array $credentials
     * @param  bool  $remember    Remember the user
     * @return mixed
     */
    public function login(array $credentials, $remember = false)
    {
       
    }

    /**
     * Log the user out of the application.
     * @return bool
     */
    public function logout()
    {
    }
}
