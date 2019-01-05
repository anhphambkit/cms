<?php

namespace Core\User\Repositories\Eloquent;

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
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
        try {
            if (Sentinel::authenticate($credentials, $remember)) {
                return false;
            }
            return __('Your account is invalid login or password');
        } catch (NotActivatedException $e) {
            return __('Your account is not validated');
        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();
            return __('Your account is blocked');
        }
    }

    /**
     * Log the user out of the application.
     * @return bool
     */
    public function logout()
    {
        return Sentinel::logout();
    }
}
