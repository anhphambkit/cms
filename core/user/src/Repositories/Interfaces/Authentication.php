<?php

namespace Core\User\Repositories\Interfaces;

interface Authentication
{
    /**
     * Authenticate a user
     * @param  array $credentials
     * @param  bool  $remember    Remember the user
     * @return mixed
     */
    public function login(array $credentials, $remember = false);

    /**
     * Log the user out of the application.
     * @return mixed
     */
    public function logout();
}
