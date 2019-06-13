<?php
/**
 * SaveForLater repository implemented
 */
namespace Plugins\Product\Repositories\Eloquent;
use Plugins\Product\Repositories\Interfaces\SaveForLaterRepositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;

class EloquentSaveForLaterRepositories extends RepositoriesAbstract implements SaveForLaterRepositories {
    /**
     * @param int $productId
     * @param int $quantity
     * @param int $customerId
     * @return bool|mixed
     */
    public function saveProductForLater(int $productId, int $quantity = 1, int $customerId = 0) {
        $dataFindOrCreate = [
            'customer_id'   => $customerId,
            'product_id' => $productId,
        ];
        $productSaveLater = $this->model->firstOrNew($dataFindOrCreate);
        $productSaveLater->quantity = $quantity;
        return $productSaveLater->save();
    }
}