<?php

namespace Core\SeoHelper\Facades;

use Core\SeoHelper\SeoHelper;
use Illuminate\Support\Facades\Facade;

/**
 * Class SeoHelperFacade
 * @package Botble\SEO\Facade
 * @author TrinhLe
 * @since 02/12/2015 14:08 PM
 */
class SeoHelperFacade extends Facade
{

    /**
     * @return string
     * @author TrinhLe
     */
    protected static function getFacadeAccessor()
    {
        return SeoHelper::class;
    }
}
