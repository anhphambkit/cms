<?php

namespace Plugins\Cart\Repositories\Eloquent;

use Core\Master\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Support\Facades\DB;
use Plugins\Cart\Repositories\Interfaces\CartRepositories;

class EloquentCartRepositories extends RepositoriesAbstract implements CartRepositories
{
    /**
     * @param int $productId
     * @param int $quantity
     * @param int $customerId
     * @param bool $isGuest
     * @param bool $isUpdate
     * @return mixed
     * @throws \Exception
     */
    public function addOrUpdateProductsToCartOfCustomer(int $productId, int $quantity = 1, int $customerId = 0, bool $isGuest = false, bool $isUpdate = true) {
        try {
            $dataFindOrCreate = [
                'customer_id'   => $customerId,
                'product_id' => $productId,
                'is_guest'   => $isGuest
            ];

            $productInCart = $this->model->firstOrNew($dataFindOrCreate);

            if ($isUpdate) // Mode update
                $productInCart->quantity = $quantity;
            else
                $productInCart->quantity = ($productInCart->quantity + $quantity);

            return $productInCart->save();
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param int|null $customerId
     * @param bool $isGuest
     * @return mixed
     * @throws \Exception
     */
    public function getBasicInfoCartOfCustomer(int $customerId = null, bool $isGuest = false) {
        try {
            $query = $this->model->select('products.id', 'products.name', 'products.slug', 'products.sku',
                'products.price', 'products.sale_price', "quantity", 'products.image_feature', 'products.sale_start_date', 'products.sale_end_date',
                DB::raw('array_to_json(array_remove(array_agg(DISTINCT lcms_category.*), null)) as categories')
//                array_to_json(array_remove(array_agg(DISTINCT lcms_media_tbl.*), null)) as medias
            )
                ->leftJoin('products', "product_id", '=', 'products.id')
                ->leftJoin('product_categories_relation as relation', 'relation.product_id', '=', 'products.id')
                ->leftJoin('product_categories as category', 'category.id', '=', 'relation.product_category_id')
//                ->leftJoin('product_galleries as media_tbl', 'media_tbl.product_id', '=', 'feature_product_tbl.media_id')
                ->groupBy('products.id', "quantity")
                ->where("customer_id", $customerId)
                ->where("is_guest", $isGuest)
                ->where("quantity", ">", 0)
                ->where('products.status', true)
                ->get();
            return $query;
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param int $customerId
     * @param bool $isGuest
     * @return mixed
     * @throws \Exception
     */
    public function getTotalItemsInCart(int $customerId, bool $isGuest = false) {
        try {
            $query = $this->model->select("quantity")
                ->leftJoin('products', "product_id", '=', 'products.id')
                ->where("customer_id", $customerId)
                ->where("is_guest", $isGuest)
                ->where('products.status', true)
                ->get();
            return $query->sum('quantity');
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param array $idProducts
     * @param int|null $customerId
     * @param bool $isGuest
     * @return mixed
     * @throws \Exception
     */
    public function deleteListProductInCart(array $idProducts, int $customerId = null, bool $isGuest = false) {
        return $this->model
            ->where("customer_id", $customerId)
            ->where("is_guest", $isGuest)
            ->whereIn('product_id', $idProducts)
            ->delete();
    }
}
