<?php

namespace Plugins\Cart\Repositories\Interfaces;

use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface CartRepositories extends RepositoryInterface
{
    /**
     * @param int $productId
     * @param int $quantity
     * @param int $customerId
     * @param bool $isGuest
     * @param bool $isUpdate
     * @return mixed
     */
    public function addOrUpdateProductsToCartOfCustomer(int $productId, int $quantity = 1, int $customerId = 0, bool $isGuest = true, bool $isUpdate = true);

    /**
     * @param int|null $customerId
     * @param bool $isGuest
     * @return mixed
     */
    public function getBasicInfoCartOfCustomer(int $customerId = null, bool $isGuest = true);

    /**
     * @param int $customerId
     * @param bool $isGuest
     * @return mixed
     */
    public function getTotalItemsInCart(int $customerId, bool $isGuest = true);

    /**
     * @param array $idProducts
     * @param int|null $customerId
     * @param bool $isGuest
     * @return mixed
     * @throws \Exception
     */
    public function deleteListProductInCart(array $idProducts, int $customerId = null, bool $isGuest = true);
}
