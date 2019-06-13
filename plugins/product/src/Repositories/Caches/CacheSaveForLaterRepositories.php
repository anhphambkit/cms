<?php
namespace Plugins\Product\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Product\Repositories\Interfaces\SaveForLaterRepositories;

class CacheSaveForLaterRepositories extends CacheAbstractDecorator implements SaveForLaterRepositories
{
    /**
     * @var SaveForLaterRepositories
     */
    protected $repository;

    /**
     * CacheSaveForLaterRepositories constructor.
     * @param SaveForLaterRepositories $repository
     */
    public function __construct(SaveForLaterRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'save-for-later-cache'; # Please setup reference name of cache.
    }

    /**
     * @param int $productId
     * @param int $quantity
     * @param int $customerId
     * @return bool|mixed
     */
    public function saveProductForLater(int $productId, int $quantity = 1, int $customerId = 0) {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
