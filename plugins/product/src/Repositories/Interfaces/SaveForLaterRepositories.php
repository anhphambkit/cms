<?php
namespace Plugins\Product\Repositories\Interfaces;
use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface SaveForLaterRepositories extends RepositoryInterface{
    /**
     * @param int $productId
     * @param int $quantity
     * @param int $customerId
     * @return bool|mixed
     */
    public function saveProductForLater(int $productId, int $quantity = 1, int $customerId = 0);
}