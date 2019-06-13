<?php
namespace Plugins\Product\Repositories\Interfaces;
use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface ProductCouponRepositories extends RepositoryInterface{
    /**
     * @param string $couponCode
     * @return mixed
     */
    public function findCouponValidByCouponCode(string $couponCode);

    /**
     * @param int $couponId
     * @return mixed
     */
    public function updateNumberUseOfCoupon(int $couponId);
}