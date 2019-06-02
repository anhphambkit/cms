<?php

namespace Plugins\Cart\Repositories\Caches;

use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Cart\Repositories\Interfaces\CartRepositories;

class CacheCartRepositories extends CacheAbstractDecorator implements CartRepositories
{
    /**
     * @var CartRepositories
     */
    protected $repository;

    /**
     * CartCacheDecorator constructor.
     * @param CartRepositories $repository
     * @author TrinhLe
     */
    public function __construct(CartRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = "Cache-Cart"; # Please setup reference name of cache.
    }
}
