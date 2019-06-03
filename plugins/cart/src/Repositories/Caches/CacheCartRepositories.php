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

    /**
     * @param int $productId
     * @param int $quantity
     * @param int $customerId
     * @param bool $isGuest
     * @param bool $isUpdate
     * @return mixed
     */
    public function addOrUpdateProductsToCartOfCustomer(int $productId, int $quantity = 1, int $customerId = 0, bool $isGuest = false, bool $isUpdate = true) {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null $customerId
     * @param bool $isGuest
     * @return mixed
     */
    public function getBasicInfoCartOfCustomer(int $customerId = null, bool $isGuest = false) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param int $customerId
     * @param bool $isGuest
     * @return mixed
     */
    public function getTotalItemsInCart(int $customerId, bool $isGuest = false) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $idProducts
     * @param int|null $customerId
     * @param bool $isGuest
     * @return mixed
     * @throws \Exception
     */
    public function deleteListProductInCart(array $idProducts, int $customerId = null, bool $isGuest = false) {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
