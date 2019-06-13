<?php
/**
 * ProductCoupon repository implemented
 */
namespace Plugins\Product\Repositories\Eloquent;
use Carbon\Carbon;
use Plugins\Product\Repositories\Interfaces\ProductCouponRepositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;

class EloquentProductCouponRepositories extends RepositoriesAbstract implements ProductCouponRepositories {
    /**
     * @param string $couponCode
     * @return mixed
     */
    public function findCouponValidByCouponCode(string $couponCode) {
        $now = Carbon::now();
        $query = $this->model
                    ->select('*')
                    ->whereRaw('lower(code) = ?', $couponCode)
                    ->whereDate('start_date', '<=', $now)
                    ->whereDate('end_date', '>=', $now)
                    ->where('number', '>', 0)
                    ->first();
        return $query;
    }

    /**
     * @param int $couponId
     * @return mixed
     */
    public function updateNumberUseOfCoupon(int $couponId)
    {
        $couponInstance = $this->findById($couponId);
        $couponInstance->number = ($couponInstance->number - 1) ? ($couponInstance->number - 1) : 0;
        return $couponInstance->save();
    }
}