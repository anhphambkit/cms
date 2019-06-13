<?php
/**
 * WishList repository implemented
 */
namespace Plugins\Product\Repositories\Eloquent;
use Plugins\Product\Repositories\Interfaces\WishListRepositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;

class EloquentWishListRepositories extends RepositoriesAbstract implements WishListRepositories {
    /**
     * @param int $productId
     * @param int $customerId
     * @return mixed
     */
    public function addOrRemoveProductToQuickList(int $productId, int $customerId) {
        $exist = $this->model
                        ->where('product_id', $productId)
                        ->where('customer_id', $customerId)
                        ->exists();

        if ($exist) {
            $this->deleteBy([
                [
                    'product_id', '=', $productId,
                    'customer_id', '=', $customerId,
                ]
            ]);
            $result = "remove";
        }
        else {
            $data = [
                'product_id' => $productId,
                'customer_id' => $customerId
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
    public function getArrayIdWishListProductsByCustomer(int $customerId) {
        return $this->allBy([
            [
                'customer_id', '=', $customerId
            ]
        ], [], ['product_id'])->pluck('product_id')->toArray();
    }
}