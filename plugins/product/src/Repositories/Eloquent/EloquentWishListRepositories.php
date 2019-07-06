<?php
/**
 * WishList repository implemented
 */
namespace Plugins\Product\Repositories\Eloquent;
use Plugins\Product\Contracts\ProductReferenceConfig;
use Plugins\Product\Repositories\Interfaces\WishListRepositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;

class EloquentWishListRepositories extends RepositoriesAbstract implements WishListRepositories {
    /**
     * @param int $entityId
     * @param int $customerId
     * @param string $typeEntity
     * @return mixed|string
     */
    public function addOrRemoveProductToQuickList(int $entityId, int $customerId, string $typeEntity = ProductReferenceConfig::ENTITY_TYPE_PRODUCT) {
        $exist = $this->model
                        ->where('entity_id', $entityId)
                        ->where('entity_type', $typeEntity)
                        ->where('customer_id', $customerId)
                        ->exists();

        if ($exist) {
            $this->deleteBy([
                [
                    'entity_id', '=', $entityId,
                ],
                [
                    'customer_id', '=', $customerId,
                ],
                [
                    'entity_type', '=', $typeEntity,
                ]
            ]);
            $result = "remove";
        }
        else {
            $data = [
                'entity_id' => $entityId,
                'customer_id' => $customerId,
                'entity_type' => $typeEntity,
            ];
            $this->insert($data);
            $result = "add";
        }
        return $result;
    }

    /**
     * @param int $customerId
     * @return mixed
     */
    public function getArrayIdWishListByCustomer(int $customerId) {
        return $this->allBy([
            [
                'customer_id', '=', $customerId
            ]
        ], [], ['entity_id', 'entity_type'])->mapToGroups(function ($item, $key) {
            return [$item['entity_type'] => $item['entity_id']];
        })->toArray();
    }
}