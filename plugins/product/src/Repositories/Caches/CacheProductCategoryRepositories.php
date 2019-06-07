<?php
namespace Plugins\Product\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories;

class CacheProductCategoryRepositories extends CacheAbstractDecorator implements ProductCategoryRepositories
{
    /**
     * @var ProductCategoryRepositories
     */
    protected $repository;

    /**
     * CacheProductCategoryRepositories constructor.
     * @param ProductCategoryRepositories $repository
     */
    public function __construct(ProductCategoryRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'product-category-cache'; # Please setup reference name of cache.
    }

    /**
     * @param int $categoryId
     * @return mixed
     */
    public function getCategoryById(int $categoryId) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param int $categoryId
     * @return mixed
     */
    public function getAllSubCategoryIdOfCategory(int $categoryId) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
