<?php

namespace Plugins\Productcategory\Repositories\Caches;

use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Productcategory\Repositories\Interfaces\ProductcategoryRepositories;

class CacheProductcategoryRepositories extends CacheAbstractDecorator implements ProductcategoryRepositories
{
    /**
     * @var ProductcategoryRepositories
     */
    protected $repository;

    /**
     * ProductcategoryCacheDecorator constructor.
     * @param ProductcategoryRepositories $repository
     * @author TrinhLe
     */
    public function __construct(ProductcategoryRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = "Cache-Productcategory"; # Please setup reference name of cache.
    }
}
