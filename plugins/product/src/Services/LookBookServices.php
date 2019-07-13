<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-10
 * Time: 21:29
 */

namespace Plugins\Product\Services;

use Illuminate\Database\Eloquent\Collection;

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
     * @param array $businessTypes
     * @param array $spaces
     * @param array $exceptBusinessType
     * @param bool $hasFirstMainBlock
     * @param array $productIds
     * @return mixed
     */
    public function getBlockRenderLookBook(int $numberBlock = 0, array $businessTypes = [], array $spaces = [],
                                           array $exceptBusinessType = [], bool $hasFirstMainBlock = false, array $productIds = []);

    /**
     * @param int $lookBookId
     * @return mixed
     */
    public function getDetailLookBook(int $lookBookId);

    /**
     * @param array $mainLookBooks
     * @param array $normalLookBooks
     * @param array $verticalLookBooks
     * @param bool $hasFirstMainBlock
     * @param int $numberBlock
     * @return array
     */
    public function getBlockRendersFromLookBook(array $mainLookBooks, array $normalLookBooks, array $verticalLookBooks, bool $hasFirstMainBlock = true, int $numberBlock = 0);

    /**
     * @param Collection $lookBooks
     * @return mixed
     */
    public function getTypeLookBookFromCollectionLookBook(Collection $lookBooks);

    /**
     * @param Collection $lookBooks
     * @return array
     */
    public function renderListBlockLookBookFromCollectionLookBook(Collection $lookBooks);
}