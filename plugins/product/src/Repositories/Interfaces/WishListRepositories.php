<?php
namespace Plugins\Product\Repositories\Interfaces;
use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface WishListRepositories extends RepositoryInterface{
    /**
     * @param int $productId
     * @param int $customerId
     * @return mixed
     */
    public function addOrRemoveProductToQuickList(int $productId, int $customerId);

    /**
     * @param int $customerId
     * @return mixed
     */
    public function getArrayIdWishListProductsByCustomer(int $customerId);
}