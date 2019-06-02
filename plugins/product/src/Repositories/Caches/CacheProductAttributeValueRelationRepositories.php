<?php
namespace Plugins\Product\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Product\Repositories\Interfaces\ProductAttributeValueRelationRepositories;

class CacheProductAttributeValueRelationRepositories extends CacheAbstractDecorator implements ProductAttributeValueRelationRepositories
{
    /**
     * @var ProductAttributeValueRelationRepositories
     */
    protected $repository;

    /**
     * CacheProductAttributeValueRelationRepositories constructor.
     * @param ProductAttributeValueRelationRepositories $repository
     */
    public function __construct(ProductAttributeValueRelationRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'cache-product-attribute-value-relation'; # Please setup reference name of cache.
    }

    /**
     * @param array $listVariantProductId
     * @param array $whereAttributes
     * @return mixed
     */
    public function getProductsByWhereAttributesOfVariantProduct(array $listVariantProductId, array $whereAttributes) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
