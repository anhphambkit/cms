<?php
use Core\Master\Facades\DashboardMenuFacade;

if (!function_exists('check_database_connection')) {
    /**
     * Check connection to DB
     * @return boolean
     * @author TrinhLe
     */
    function check_database_connection()
    {
        try {
            DB::connection()->reconnect();
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}

if (!function_exists('parse_args')) {
    /**
     * @param $args
     * @param string $defaults
     * @return array
     */
    function parse_args($args, $defaults = '')
    {
        if (is_object($args)) {
            $result = get_object_vars($args);
        } else {
            $result =& $args;
        }

        if (is_array($defaults)) {
            return array_merge($defaults, $result);
        }
        return $result;
    }
}

if (!function_exists('dashboard_menu')) {
    /**
     * @return \Core\Base\Supports\DashboardMenu
     */
    function dashboard_menu()
    {
        return DashboardMenuFacade::getFacadeRoot();
    }
}