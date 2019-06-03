<?php

namespace Plugins\Product\Repositories\Interfaces;

use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface ProductRepositories extends RepositoryInterface
{
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
    public function getBestSellerProducts($limit = 8);
}
