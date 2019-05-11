<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-10
 * Time: 21:29
 */

namespace Plugins\Product\Services;

interface LookBookServices {
    /**
     * @param string $type
     * @param bool $isMain
     * @return mixed
     */
    public function getAllLookBookByTypeLayout(string $type, bool $isMain = false);

    /**
     * @return mixed
     */
    public function getBlockRenderLookBook();
}