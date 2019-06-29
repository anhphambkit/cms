<?php

namespace Plugins\Product\Repositories\Interfaces;

use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface ProductRepositories extends RepositoryInterface
{
    /**
     * @param array $categoryIds
     * @param int|null $limit
     * @param array $filterPageLoad
     * @return array
     */
    public function getAllSaleProductsByCategory(array $categoryIds, int $limit = null, array $filterPageLoad = []);

    /**
     * @param array $categoryIds
     * @param int|null $limit
     * @param array $filterPageLoad
     * @return mixed
     */
    public function getAllProductsByCategory(array $categoryIds, int $limit = null, array $filterPageLoad = []);

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
     * @param array $listId
     * @return mixed
     */
    public function getAllProductByListId(array $listId);

    /**
     * @param array $collectionIds
     * @param int $limit
     * @return mixed
     */
    public function getAllProductInCollections(array $collectionIds, int $limit = null);

    /**
     * @param int $limit
     * @return mixed
     */
    public function getBestSellerProducts(int $limit = 8);
//
//    /**
//     * @param array $categoryIds
//     * @return mixed
//     */
//    public function getAllSaleProductsOfCategories(array $categoryIds);
}
