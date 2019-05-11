<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-10
 * Time: 18:04
 */

namespace Plugins\Product\Services;

interface BusinessTypeServices {
    /**
     * @return mixed
     */
    public function getAllBusinessTypeGroupByParent();
}