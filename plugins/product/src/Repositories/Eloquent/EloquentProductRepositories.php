<?php

namespace Plugins\Product\Repositories\Eloquent;

use Core\Master\Repositories\Eloquent\RepositoriesAbstract;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;

class EloquentProductRepositories extends RepositoriesAbstract implements ProductRepositories
{
    /**
     * @param int|null $categoryId
     * @return mixed
     * @throws \Exception
     */
    public function getAllProductsByCategory(int $categoryId = null)
    {
        try {
            $query = $this->model->products();
            return $query->get();
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param int $productId
     * @return mixed
     */
    public function getOverviewInfoProductPopup(int $productId) {
        return $this->model
                        ->select('id', 'name', 'slug', 'price', 'sale_price', 'image_feature')
                        ->where('id', $productId)
                        ->first();
    }
}
