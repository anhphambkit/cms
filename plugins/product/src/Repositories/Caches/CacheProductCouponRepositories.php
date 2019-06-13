<?php
namespace Plugins\Product\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Product\Repositories\Interfaces\ProductCouponRepositories;

class CacheProductCouponRepositories extends CacheAbstractDecorator implements ProductCouponRepositories
{
    /**
     * @var ProductCouponRepositories
     */
    protected $repository;

    /**
     * CacheProductCouponRepositories constructor.
     * @param ProductCouponRepositories $repository
     */
    public function __construct(ProductCouponRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'coupon-cache-repo'; # Please setup reference name of cache.
    }

    /**
     * @param string $couponCode
     * @return mixed
     */
    public function findCouponValidByCouponCode(string $couponCode) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param int $couponId
     * @return mixed
     */
    public function updateNumberUseOfCoupon(int $couponId) {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
