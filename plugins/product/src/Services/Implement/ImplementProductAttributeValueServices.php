<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-02
 * Time: 01:23
 */

namespace Plugins\Product\Services\Implement;

use Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories;
use Plugins\Product\Services\ProductAttributeValueServices;

class ImplementProductAttributeValueServices implements ProductAttributeValueServices {

    private $repository;

    /**
     * ImplementProductCategoryServices constructor.
     * @param ProductCategoryRepositories $productCategoryRepositories
     */
    public function __construct(ProductCategoryRepositories $productCategoryRepositories)
    {
        $this->repository = $productCategoryRepositories;
    }

}