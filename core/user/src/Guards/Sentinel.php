<?php

namespace Core\User\Guards;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel as SentinelFacade;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard as LaravelGuard;

class Sentinel implements LaravelGuard
{
    /**
     * Determine if the current user is authenticated.
     * @return bool
     */
    public function check()
    {
        if (SentinelFacade::check()) {
            return true;
        }
        return false;
    }

    /**
     * Determine if the current user is a guest.
     * @return bool
     */
    public function guest()
    {
        return SentinelFacade::guest();
    }

    /**
     * Get the currently authenticated user.
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        return SentinelFacade::getUser();
    }

    /**
     * Get the ID for the currently authenticated user.
     * @return int|null
     */
    public function id()
    {
        if ($user = SentinelFacade::check()) {
            return $user->id;
        }
        return null;
    }

    /**
     * Validate a user's credentials.
     * @param  array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        return SentinelFacade::validForCreation($credentials);
    }

    /**
     * Set the current user.
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @return void
     */
    public function setUser(Authenticatable $user)
    {
        SentinelFacade::login($user);
    }

    /**
     * Alias to set the current user.
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @return void
     */
    public function login(Authenticatable $user)
    {
        $this->setUser($user);
    }

    public function attempt(array $credentials, $remember = false)
    {
        return SentinelFacade::authenticate($credentials, $remember);
    }
}
