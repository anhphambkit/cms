<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-03
 * Time: 08:58
 */

namespace Plugins\Customer\Services;


interface IProductsInOrderServices
{
    /**
     * @param array $data
     * @return mixed
     */
    public function insertProductsInOrder(array $data);

    /**
     * @param int $orderId
     * @return mixed
     */
    public function getAllProductsInOrder(int $orderId);
}