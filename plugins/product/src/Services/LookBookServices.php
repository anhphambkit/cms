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
     * @param int $take
     * @return mixed
     */
    public function getAllLookBookByTypeLayout(string $type, bool $isMain = false, int $take = 0);

    /**
     * @param int $numberBlock
     * @param int $businessTypeId
     * @param int $spaceId
     * @return mixed
     */
    public function getBlockRenderLookBook(int $numberBlock = 0, int $businessTypeId = 0, int $spaceId = 0);

    /**
     * @param int $numberBlock
     * @return mixed
     */
    public function getNewestBlockRenderLookBook(int $numberBlock = 1);
}