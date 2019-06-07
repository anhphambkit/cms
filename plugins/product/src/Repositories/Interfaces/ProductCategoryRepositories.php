<?php
namespace Plugins\Product\Repositories\Interfaces;
use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface ProductCategoryRepositories extends RepositoryInterface{
    /**
     * @param int $categoryId
     * @return mixed
     */
    public function getCategoryById(int $categoryId);

    /**
     * @param int $categoryId
     * @return mixed
     */
    public function getAllSubCategoryIdOfCategory(int $categoryId);
}