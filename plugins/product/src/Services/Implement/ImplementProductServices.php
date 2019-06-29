<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 11/7/18
 * Time: 03:32
 */

namespace Plugins\Product\Services\Implement;

use Illuminate\Support\Facades\DB;
use Plugins\Cart\Repositories\Interfaces\CartRepositories;
use Plugins\Product\Contracts\ProductReferenceConfig;
use Plugins\Product\Repositories\Interfaces\ProductAttributeValueRelationRepositories;
use Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;
use Plugins\Product\Repositories\Interfaces\SaveForLaterRepositories;
use Plugins\Product\Repositories\Interfaces\WishListRepositories;
use Plugins\Product\Services\ProductServices;

class ImplementProductServices implements ProductServices {

    const NUMBER_PRODUCTS_OF_SLIDER = 8;
    /**
     * @var ProductRepositories
     */
    private $repository;

    /**
     * @var ProductAttributeValueRelationRepositories
     */
    private $productAttributeValueRepositories;

    /**
     * @var ProductCategoryRepositories
     */
    private $productCategoryRepositories;

    /**
     * @var WishListRepositories
     */
    private $wishListRepositories;

    /**
     * @var SaveForLaterRepositories
     */
    private $saveForLaterRepositories;

    /**
     * @var CartRepositories
     */
    private $cartRepositories;

    /**
     * ImplementProductServices constructor.
     * @param ProductRepositories $productRepository
     * @param ProductAttributeValueRelationRepositories $productAttributeValueRepositories
     * @param SaveForLaterRepositories $saveForLaterRepositories
     * @param ProductCategoryRepositories $productCategoryRepositories
     * @param WishListRepositories $wishListRepositories
     * @param CartRepositories $cartRepositories
     */
    public function __construct(ProductRepositories $productRepository,
                                ProductAttributeValueRelationRepositories $productAttributeValueRepositories, SaveForLaterRepositories $saveForLaterRepositories,
                                ProductCategoryRepositories $productCategoryRepositories, WishListRepositories $wishListRepositories, CartRepositories $cartRepositories)
    {
        $this->repository = $productRepository;
        $this->productAttributeValueRepositories = $productAttributeValueRepositories;
        $this->productCategoryRepositories = $productCategoryRepositories;
        $this->wishListRepositories = $wishListRepositories;
        $this->saveForLaterRepositories = $saveForLaterRepositories;
        $this->cartRepositories = $cartRepositories;
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
        $collectionProducts = $this->repository->getAllProductInCollections($collectionIds, self::NUMBER_PRODUCTS_OF_SLIDER);
        $similarProducts = $this->repository->getAllProductsByCategory($categoryIds, self::NUMBER_PRODUCTS_OF_SLIDER);
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

    /**
     * @param int $limit
     * @return mixed
     */
    public function getBestSellerProducts(int $limit = self::NUMBER_PRODUCTS_OF_SLIDER) {
        return $this->repository->getBestSellerProducts($limit);
    }

    /**
     * @param int $productCategoryId
     * @param int|null $limit
     * @param array $dataPageLoad
     * @return array|mixed
     */
    public function getListProductsOfCategoryPage(int $productCategoryId, int $limit = null, array $dataPageLoad = []) {
        $category = $this->productCategoryRepositories->getCategoryById($productCategoryId);
        if (empty($category))
            abort(404);
        $subCategories = $category->childCategories;
        $products = $this->repository->getAllProductsByCategory($subCategories->pluck('id')->toArray(), $limit, $dataPageLoad);
        $saleProducts = $products['data']->where('is_has_sale', true)->all();
        return [
            'sale_products' => $saleProducts,
            'sub_categories' => $subCategories,
            'category' => $category,
        ];
    }

    /**
     * @param int $productCategoryId
     * @param int|null $limit
     * @param array $dataPageLoad
     * @return array|mixed
     */
    public function getListProductsOfSubCategoryPage(int $productCategoryId, int $limit = null, array $dataPageLoad = []) {
        $category = $this->productCategoryRepositories->getCategoryById($productCategoryId);
        if (empty($category))
            abort(404);
        $products = $this->repository->getAllProductsByCategory([$productCategoryId], $limit, $dataPageLoad);
        $saleProducts = $products['data']->where('is_has_sale', true)->all();
        return [
            'products' => $saleProducts,
            'category' => $category,
        ];
    }

    /**
     * @param int $productCategoryId
     * @param int|null $limit
     * @param array $dataPageLoad
     * @return array|mixed
     */
    public function getListSaleProductsOfCategoryPageParent(int $productCategoryId, int $limit = null, array $dataPageLoad = []) {
        $category = $this->productCategoryRepositories->getCategoryById($productCategoryId);
        if (empty($category))
            abort(404);
        $products = $this->repository->getAllSaleProductsByCategory($category->childCategories->pluck('id')->toArray(), $limit, $dataPageLoad);
        return [
            'sale_products' => $products,
            'category' => $category,
        ];
    }

    /**
     * @param int $productId
     * @param int $customerId
     * @return mixed
     */
    public function addOrRemoveProductToQuickList(int $productId, int $customerId) {
        $result = $this->wishListRepositories->addOrRemoveProductToQuickList($productId, $customerId);
        return [
            'type_update' => $result,
            'message' => trans('plugins-product::wish-list.update_wish_list_success')
        ];
    }

    /**
     * @param array $products
     * @param int $customerId
     * @return mixed
     */
    public function saveProductForLater(array $products, int $customerId) {
        foreach ($products as $productId => $quantity) {
            $quantity = intval($quantity) > 0 ? intval($quantity) : 1;
            DB::transaction(function () use ($productId, $quantity, $customerId) {
                $this->saveForLaterRepositories->saveProductForLater(intval($productId), $quantity, $customerId);
                $this->cartRepositories->addOrUpdateProductsToCartOfCustomer(intval($productId), 0, $customerId, false, true);
            }, 3);
        }
        return [
            'message' => trans('plugins-product::save-for-later.save_product_later_success')
        ];
    }

    /**
     * @param int $productId
     * @param int $customerId
     * @return array|mixed
     */
    public function moveProductToCart(int $productId, int $customerId) {
        $conditions = [
            [
                'product_id', '=', $productId
            ],
            [
                'customer_id', '=', $customerId
            ],
        ];
        $productSaveForLater = $this->saveForLaterRepositories->getFirstBy($conditions);
        if ($productSaveForLater) {
            DB::transaction(function () use ($productId, $customerId, $productSaveForLater, $conditions) {
                $this->cartRepositories->addOrUpdateProductsToCartOfCustomer(intval($productId), $productSaveForLater->quantity, $customerId, false, true);
                $this->saveForLaterRepositories->deleteBy($conditions);
            }, 3);
        }
        return [
            'message' => trans('plugins-product::save-for-later.save_product_later_success')
        ];
    }

    /**
     * @param int $productId
     * @param int $customerId
     * @return mixed
     */
    public function deleteProductSaved(int $productId, int $customerId) {
        return $this->saveForLaterRepositories->deleteBy([
            [
                'product_id', '=', $productId
            ],
            [
                'customer_id', '=', $customerId
            ],
        ]);
    }
}