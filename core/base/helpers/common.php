<?php
use Core\Master\Facades\DashboardMenuFacade;
use Core\Master\Facades\PageTitleFacade;
use Core\Master\Facades\AdminBreadcrumbFacade;
use Core\Master\Supports\Editor;

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
if (!function_exists('html_attribute_element')) {
    /**
     * @param $key
     * @param $value
     * @return string
     * @author Trinh Le
     */
    function html_attribute_element($key, $value)
    {
        if (is_numeric($key)) {
            return $value;
        }

        // Treat boolean attributes as HTML properties
        if (is_bool($value) && $key != 'value') {
            return $value ? $key : '';
        }

        if (!empty($value)) {
            return $key . '="' . e($value) . '"';
        }
    }
}

if (!function_exists('html_attributes_builder')) {
    /**
     * @param array $attributes
     * @return string
     * @author Trinh Le
     */
    function html_attributes_builder(array $attributes)
    {
        $html = [];

        foreach ((array)$attributes as $key => $value) {
            $element = html_attribute_element($key, $value);

            if (!empty($element)) {
                $html[] = $element;
            }
        }

        return count($html) > 0 ? ' ' . implode(' ', $html) : '';
    }
}

if (!function_exists('render_editor')) {
    /**
     * @param $name
     * @param null $value
     * @param bool $with_short_code
     * @param array $attributes
     * @return string
     * @author Trinh Le
     * @throws Throwable
     */
    function render_editor($name, $value = null, $with_short_code = false, array $attributes = [])
    {
        $editor = new Editor;

        return $editor->render($name, $value, $with_short_code, $attributes);
    }
}