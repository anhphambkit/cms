<?php

namespace Plugins\Customer\Services;

interface IOrderService
{
    /**
     * @param array $dataCheckouts
     * @param int $customerId
     * @param bool $isGuest
     * @return mixed
     */
    public function createOrderCustomerProduct(array $dataCheckouts, int $customerId, bool $isGuest = false);
}
