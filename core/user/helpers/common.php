<?php

use Core\User\Models\UserMeta;
use Illuminate\Http\Request;
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