<?php

namespace Core\Master\Facades;

use Core\Master\Supports\AdminBreadcrumb;
use Illuminate\Support\Facades\Facade;

/**
 * Class AdminBreadcrumbFacade
 * @package Core\Master
 */
class AdminBreadcrumbFacade extends Facade
{

    /**
     * @return string
     * @author Sang Nguyen
     * @since 2.1
     */
    protected static function getFacadeAccessor()
    {
        return AdminBreadcrumb::class;
    }
}
