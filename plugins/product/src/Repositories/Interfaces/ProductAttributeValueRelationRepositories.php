<?php
namespace Plugins\Product\Repositories\Interfaces;
use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface ProductAttributeValueRelationRepositories extends RepositoryInterface{
    /**
     * @param array $listVariantProductId
     * @param array $whereAttributes
     * @return mixed
     */
    public function getProductsByWhereAttributesOfVariantProduct(array $listVariantProductId, array $whereAttributes);
}