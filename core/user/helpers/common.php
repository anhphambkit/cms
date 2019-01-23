<?php

use Core\User\Models\UserMeta;
use Cartalyst\Sentinel\Activations\EloquentActivation;
use Illuminate\Http\Request;

if (!function_exists('acl_get_current_user')) {
    /**
     * @return \Botble\ACL\Models\User|bool|\Cartalyst\Sentinel\Users\UserInterface
     * @author TrinhLe
     */
    function acl_get_current_user() {
        return Sentinel::getUser();
    }
}

if (!function_exists('acl_get_current_user_id')) {
    /**
     * @return int|null
     * @author TrinhLe
     */
    function acl_get_current_user_id() {
        if ($user = Sentinel::check()) {
            return $user->getUserId();
        }
        return null;
    }
}

if (!function_exists('acl_check_login')) {
    /**
     * @return bool|\Cartalyst\Sentinel\Users\UserInterface
     * @author TrinhLe
     */
    function acl_check_login() {
        return Sentinel::check();
    }
}

if (!function_exists('acl_activate_user')) {
    /**
     * @param \Botble\ACL\Models\User $user
     * @return bool
     * @author TrinhLe
     */
    function acl_activate_user($user) {
        /**
         * @var EloquentActivation $activation
         */
        $activation = Sentinel::getActivationRepository()->create($user);
        if (Sentinel::getActivationRepository()->complete($user, $activation->code)) {
            return true;
        }
        return false;
    }
}

if (!function_exists('acl_deactivate_user')) {
    /**
     * @param \Botble\ACL\Models\User $user
     * @return bool
     * @author TrinhLe
     */
    function acl_deactivate_user($user) {
        return Sentinel::getActivationRepository()->remove($user);
    }
}

if (!function_exists('acl_is_user_activated')) {
    /**
     * @param \Botble\ACL\Models\User $user
     * @return bool
     * @author TrinhLe
     */
    function acl_is_user_activated($user) {
        return Sentinel::getActivationRepository()->completed($user);
    }
}

if (!function_exists('render_login_form')) {
    /**
     * @return string
     * @author TrinhLe
     */
    function render_login_form() {
        return view('acl::partials.login-form')->render();
    }
}

if (!function_exists('get_user_meta')) {
    /**
     * @param $key
     * @param null $default
     * @return mixed
     * @author TrinhLe
     */
    function get_user_meta($key, $default = null) {
        return UserMeta::getMeta($key, $default);
    }
}

if (!function_exists('set_user_meta')) {
    /**
     * @param $key
     * @param null $value
     * @param int $user_id
     * @return mixed
     * @internal param null $default
     * @author TrinhLe
     */
    function set_user_meta($key, $value = null, $user_id = 0) {
        return UserMeta::setMeta($key, $value, $user_id);
    }
}