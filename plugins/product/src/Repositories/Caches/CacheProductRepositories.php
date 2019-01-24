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
     * @author TrinhLe
     */
    public function __construct(ProductRepositories $repository)
    {
        $this->repository = $repository;
        $this->entityName = "Cache-Product"; # Please setup reference name of cache.
    }
}
