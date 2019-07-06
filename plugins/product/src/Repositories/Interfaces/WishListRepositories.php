<?php
namespace Plugins\Product\Repositories\Interfaces;
use Core\Master\Repositories\Interfaces\RepositoryInterface;
use Plugins\Product\Contracts\ProductReferenceConfig;

interface WishListRepositories extends RepositoryInterface{
    /**
     * @param int $entityId
     * @param int $customerId
     * @param string $typeEntity
     * @return mixed
     */
    public function addOrRemoveProductToQuickList(int $entityId, int $customerId, string $typeEntity = ProductReferenceConfig::ENTITY_TYPE_PRODUCT);

    /**
     * @param int $customerId
     * @return mixed
     */
    public function getArrayIdWishListByCustomer(int $customerId);
}