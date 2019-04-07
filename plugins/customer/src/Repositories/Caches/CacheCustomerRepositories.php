<?php

namespace Plugins\Customer\Repositories\Caches;

use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;

class CacheCustomerRepositories extends CacheAbstractDecorator implements CustomerRepositories
{
    /**
     * @var CustomerRepositories
     */
    protected $repository;

    /**
     * CustomerCacheDecorator constructor.
     * @param CustomerRepositories $repository
     * @author TrinhLe
     */
    public function __construct(CustomerRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = "Cache-Customer"; # Please setup reference name of cache.
    }
}
