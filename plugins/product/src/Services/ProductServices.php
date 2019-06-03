<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 11/7/18
 * Time: 03:32
 */

namespace Plugins\Product\Services;

interface ProductServices {
    /**
     * @param array $categoryIds
     * @param int|null $limit
     * @return mixed
     * @throws \Exception
     */
    public function getAllProductsByCategory(array $categoryIds, int $limit = null);

    /**
     * @param int $productId
     * @return mixed
     */
    public function getOverviewInfoProductPopup(int $productId);

    /**
     * @param int $productId
     * @return mixed
     */
    public function getDetailInfoProduct(int $productId);

    /**
     * @param int $productId
     * @param array $productAttributes
     * @return mixed
     */
    public function getDetailInfoProductByProductIdAndAttribute(int $productId, array $productAttributes);

    /**
     * @param int $limit
     * @return mixed
     */
    public function getBestSellerProducts($limit = 8);
}