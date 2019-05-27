<?php

namespace Plugins\Customer\Services;

interface IOrderService
{
    /**
     * [createOrderCustomerProduct description]
     * @param  sessionCart
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrderCustomerProduct(array $sessionCheckout, int $paymentMethod);
}
