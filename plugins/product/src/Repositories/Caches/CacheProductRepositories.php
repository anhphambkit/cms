<?php

namespace Plugins\Product\Repositories\Caches;

use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;

class CacheProductRepositories extends CacheAbstractDecorator implements ProductRepositories
{
    /**
     * @var ProductRepositories
     */
    protected $repository;

    /**
     * ProductCacheDecorator constructor.
     * @param ProductRepositories $repository
     * @author AnhPham
     */
    public function __construct(ProductRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = "Cache-Product"; # Please setup reference name of cache.
    }

    /**
     * @param array $categoryIds
     * @param int|null $limit
     * @param array $filterPageLoad
     * @return array
     */
    public function getAllSaleProductsByCategory(array $categoryIds, int $limit = null, array $filterPageLoad = []) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $categoryIds
     * @param int|null $limit
     * @param array $filterPageLoad
     * @return mixed
     */
    public function getAllProductsByCategory(array $categoryIds, int $limit = null, array $filterPageLoad = []) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param int $productId
     * @return mixed
     */
    public function getOverviewInfoProductPopup(int $productId) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param int $productId
     * @return mixed
     */
    public function getDetailInfoProduct(int $productId) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $listId
     * @return mixed
     */
    public function getAllProductByListId(array $listId){
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $collectionIds
     * @param int $limit
     * @return mixed
     */
    public function getAllProductInCollections(array $collectionIds, int $limit = null) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getBestSellerProducts(int $limit = 8) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
