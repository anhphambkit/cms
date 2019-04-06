<?php
use Core\Master\Facades\DashboardMenuFacade;
use Core\Master\Facades\PageTitleFacade;
use Core\Master\Facades\AdminBreadcrumbFacade;

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

if (!function_exists('page_title')) {
    /**
     * @return PageTitle
     */
    function page_title()
    {
        return PageTitleFacade::getFacadeRoot();
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

if (!function_exists('table_actions')) {
    /**
     * @param $edit
     * @param $delete
     * @param $item
     * @return string
     * @author TrinhLe
     */
    function table_actions($edit, $delete, $item)
    {
        return view('core-base::elements.tables.actions', compact('edit', 'delete', 'item'))->render();
    }
}

if (!function_exists('anchor_link')) {
    /**
     * @param $link
     * @param $name
     * @param array $options
     * @return string
     * @author TrinhLe
     */
    function anchor_link($link, $name, array $options = [])
    {
        $options = Html::attributes($options);
        return view('core-base::elements.tables.link', compact('link', 'name', 'options'))->render();
    }
}

if (!function_exists('table_checkbox')) {
    /**
     * @param $id
     * @return string
     * @author TrinhLe
     * @throws Throwable
     */
    function table_checkbox($id)
    {
        return view('core-base::elements.tables.checkbox', compact('id'))->render();
    }
}