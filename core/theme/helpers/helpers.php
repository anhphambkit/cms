<?php

use Core\Theme\Facades\ThemeOptionFacade;

if (!function_exists('theme_option')) {
    /**
     * @return mixed
     * @author Sang Nguyen
     */
    function theme_option($key = null, $default = null) {

        if (!empty($key)) {
            return ThemeOption::getOption($key, $default);
        }
        return ThemeOptionFacade::getFacadeRoot();
    }
}