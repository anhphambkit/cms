<?php

namespace Core\SeoHelper\Facades;

use Core\SeoHelper\MetaBox;
use Illuminate\Support\Facades\Facade;

/**
 * Class MetaBoxFacade
 * @package Botble\SeoHelper
 */
class MetaBoxFacade extends Facade
{
    /**
     * @return string
     * @author TrinhLe
     */
    protected static function getFacadeAccessor()
    {
        return MetaBox::class;
    }
}
