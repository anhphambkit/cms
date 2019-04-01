<?php

namespace Plugins\Productlookbook\Repositories\Caches;

use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Productlookbook\Repositories\Interfaces\ProductlookbookRepositories;

class CacheProductlookbookRepositories extends CacheAbstractDecorator implements ProductlookbookRepositories
{
    /**
     * @var ProductlookbookRepositories
     */
    protected $repository;

    /**
     * ProductlookbookCacheDecorator constructor.
     * @param ProductlookbookRepositories $repository
     * @author TrinhLe
     */
    public function __construct(ProductlookbookRepositories $repository)
    {
        $this->repository = $repository;
        $this->entityName = "Cache-Productlookbook"; # Please setup reference name of cache.
    }
}
