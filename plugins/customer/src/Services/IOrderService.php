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

    /**
     * @param array $conditions
     * @param array $data
     * @return mixed
     */
    public function updateOrder(array $conditions, array $data);

    /**
     * [getMyOrders description]
     * @param  [type] $customerId [description]
     * @return [type]             [description]
     */
    public function getMyOrders(int $customerId);
}
