<?php
namespace Plugins\Product\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Product\Contracts\ProductReferenceConfig;
use Plugins\Product\Repositories\Interfaces\WishListRepositories;

class CacheWishListRepositories extends CacheAbstractDecorator implements WishListRepositories
{
    /**
     * @var WishListRepositories
     */
    protected $repository;

    /**
     * CacheWishListRepositories constructor.
     * @param WishListRepositories $repository
     */
    public function __construct(WishListRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'wish-list-cache'; # Please setup reference name of cache.
    }

    /**
     * @param int $entityId
     * @param int $customerId
     * @param string $typeEntity
     * @return mixed
     */
    public function addOrRemoveProductToQuickList(int $entityId, int $customerId, string $typeEntity = ProductReferenceConfig::ENTITY_TYPE_PRODUCT) {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * @param int $customerId
     * @return mixed
     */
    public function getArrayIdWishListProductsByCustomer(int $customerId) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
