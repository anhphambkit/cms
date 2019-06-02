<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 11/7/18
 * Time: 03:32
 */

namespace Plugins\Product\Services\Implement;

use Plugins\Product\Contracts\ProductReferenceConfig;
use Plugins\Product\Repositories\Interfaces\ProductAttributeValueRelationRepositories;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;
use Plugins\Product\Services\ProductServices;

class ImplementProductServices implements ProductServices {

    /**
     * @var ProductRepositories
     */
    private $repository;

    /**
     * @var ProductAttributeValueRelationRepositories
     */
    private $productAttributeValueRepositories;

    /**
     * ImplementProductServices constructor.
     * @param ProductRepositories $productRepository
     * @param ProductAttributeValueRelationRepositories $productAttributeValueRepositories
     */
    public function __construct(ProductRepositories $productRepository, ProductAttributeValueRelationRepositories $productAttributeValueRepositories)
    {
        $this->repository = $productRepository;
        $this->productAttributeValueRepositories = $productAttributeValueRepositories;
    }

    /**
     * @param array $categoryIds
     * @param int|null $limit
     * @return mixed
     * @throws \Exception
     */
    public function getAllProductsByCategory(array $categoryIds, int $limit = null)
    {
        try {
            return $this->repository->getAllProductsByCategory($categoryIds, $limit);
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
        return $this->repository->getOverviewInfoProductPopup($productId);
    }

    /**
     * @param int $productId
     * @return array|mixed
     * @throws \Exception
     */
    public function getDetailInfoProduct(int $productId) {
        $product = $this->repository->getDetailInfoProduct($productId);
        if (!$product)
            abort(404);
        $defaultSelectedAttributeValues = [];
        if ($product->type_product !== ProductReferenceConfig::PRODUCT_TYPE_CHILD_VARIANT) {
            $customAttributes = $product->productCustomAttributes()->get();
            $attributeValues = $product->productStringValueAttribute()->get()->groupBy('custom_attribute_id');
        }
        else {
            $parentVariantProduct = $product->parentVariantProduct()->first();
            $customAttributes = $parentVariantProduct->productCustomAttributes()->get();
            $attributeValues = $parentVariantProduct->productStringValueAttribute()->get()->groupBy('custom_attribute_id');
            $defaultSelectedAttributeValues = $product->productStringValueAttribute()->get()->groupBy('custom_attribute_id');
        }

        $collectionIds = $product->productCollections()->pluck('product_collections_relation.product_collection_id')->toArray();
        $categoryIds = $product->productCategories()->pluck('product_categories_relation.product_category_id')->toArray();
        $collectionProducts = $this->repository->getAllProductInCollections($collectionIds, 8);
        $similarProducts = $this->repository->getAllProductsByCategory($categoryIds, 8);
        return [
            'product' => $product,
            'product_attributes' => $customAttributes,
            'product_attribute_values' => $attributeValues,
            'product_default_attribute_values' => $defaultSelectedAttributeValues,
            'product_in_collection' => $collectionProducts,
            'similar_products' => $similarProducts,
        ];
    }

    /**
     * @param int $productId
     * @param array $productAttributes
     * @return mixed
     */
    public function getDetailInfoProductByProductIdAndAttribute(int $productId, array $productAttributes) {
        $product = $this->repository->findById($productId);
        $listVariantProductId = [];
        switch ($product->type_product) {
            case ProductReferenceConfig::PRODUCT_TYPE_VARIANT:
                $listVariantProductId = $product->childVariantsProduct()->pluck('id')->toArray();
                break;
            case ProductReferenceConfig::PRODUCT_TYPE_CHILD_VARIANT:
                $listVariantProductId = $product->parentVariantProduct()->first()->childVariantsProduct()->pluck('id')->toArray();
                break;
        }
        $whereAttributes = [];
        foreach ($productAttributes as $productAttribute) {
            $productAttribute = json_decode($productAttribute);
            if ((int)$productAttribute->attribute_value_id && (int)$productAttribute->attribute_id) {
                $where = [
                    'attribute_value_id' => (int)$productAttribute->attribute_value_id,
                    'attribute_id' => (int)$productAttribute->attribute_id
                ];
                array_push($whereAttributes, $where);
            }
        }
        $variantProductIds = $this->getProductsByWhereAttributesOfVariantProduct($listVariantProductId, $whereAttributes);
        if (sizeof($variantProductIds) !== 1) {
            $variantProducts = $this->repository->getAllProductByListId($variantProductIds);
            return [
                'min_price' => $variantProducts->min('min_price'),
                'max_price' => $variantProducts->max('max_price'),
                'link_product' => null
            ];
        }
        else {
            $variantProduct = $this->repository->findById(reset($variantProductIds));
            return [
                'min_price' => null,
                'max_price' => null,
                'link_product' => "{$variantProduct->slug}.{$variantProduct->id}",
            ];
        }
    }

    /**
     * @param array $listVariantProductId
     * @param array $whereAttributes
     * @return mixed
     */
    public function getProductsByWhereAttributesOfVariantProduct(array $listVariantProductId, array $whereAttributes) {
        return $this->productAttributeValueRepositories->getProductsByWhereAttributesOfVariantProduct($listVariantProductId, $whereAttributes);
    }
}