<?php
/**
 * ProductCategory repository implemented
 */
namespace Plugins\Product\Repositories\Eloquent;
use Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;

class EloquentProductCategoryRepositories extends RepositoriesAbstract implements ProductCategoryRepositories {
    /**
     * @param int $categoryId
     * @return mixed
     */
    public function getCategoryById(int $categoryId) {
        return $this->findById($categoryId, [ 'childCategories' ]);
    }

    /**
     * @param int $categoryId
     * @return mixed
     */
    public function getAllSubCategoryIdOfCategory(int $categoryId) {
        return $this->findById($categoryId, [ 'childCategories' ]);
    }
}