<?php

namespace Plugins\Product\Repositories\Eloquent;

use Core\Base\Traits\ParseFilterSearch;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;
use Plugins\Product\Contracts\ProductReferenceConfig;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;

class EloquentProductRepositories extends RepositoriesAbstract implements ProductRepositories
{
    use ParseFilterSearch;

    protected $mappingColumns = [
        'price' => 'price',
        'name' => 'name',
    ];

    protected $defaultSortOrder = 'asc';

    protected $defaultOrderBy = 'name';

    protected $defaultPage = 1;

    CONST PREFIX_FUNCTION_SALE_COLLECTION = 'getSaleProduct';

    /**
     * @param array $categoryIds
     * @param int|null $limit
     * @param array $filterPageLoad
     * @return array
     */
    public function getAllSaleProductsByCategory(array $categoryIds, int $limit = null, array $filterPageLoad = [])
    {
        $query = $this->getAllProductByListCategoryIds($categoryIds);

        if ($limit)
            $filterPageLoad['limit'] = !empty($filterPageLoad['limit']) ? $filterPageLoad['limit'] : $limit;

        $result = $this->getResultSearchWithDataPageLoadCollection($query, $filterPageLoad, self::PREFIX_FUNCTION_SALE_COLLECTION);

        return $result;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function getSaleProductCollectionData(&$data) {
        return $data = $data->where('is_has_sale', true);
    }

    /**
     * @param array $categoryIds
     * @param int|null $limit
     * @param array $filterPageLoad
     * @return array|mixed
     */
    public function getAllProductsByCategory(array $categoryIds, int $limit = null, array $filterPageLoad = [])
    {
        $query = $this->getAllProductByListCategoryIds($categoryIds);

        if ($limit)
            $filterPageLoad['limit'] = !empty($filterPageLoad['limit']) ? $filterPageLoad['limit'] : $limit;

        $dataPageLoad = $this->getDataPageLoad($filterPageLoad);
        $result = $this->getResultSearchWithDataPageLoad($query, $dataPageLoad);

        return $result;
    }

    /**
     * @param array $categoryIds
     * @return mixed
     */
    public function getAllProductByListCategoryIds(array $categoryIds) {
        return $this->model
            ->select('products.*')
            ->leftJoin('product_categories_relation', 'products.id', '=', 'product_categories_relation.product_id')
            ->whereIn('product_categories_relation.product_category_id', $categoryIds)
            ->where('products.status', true)
            ->where('products.type_product', '!=', ProductReferenceConfig::PRODUCT_TYPE_VARIANT)
            ->with(['galleries', 'productAttributeValues', 'productCustomAttributes', 'childVariantsProduct', 'productCollections', 'productCategories']);
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

    /**
     * @param int $productId
     * @return mixed
     */
    public function getDetailInfoProduct(int $productId) {
        return $this->findById($productId, ['galleries', 'productAttributeValues', 'productCustomAttributes', 'childVariantsProduct', 'productCollections', 'productCategories']);
    }

    /**
     * @param array $listId
     * @return mixed
     */
    public function getAllProductByListId(array $listId) {
        return $this->model->whereIn('id', $listId)->get();
    }

    /**
     * @param array $collectionIds
     * @param int $limit
     * @return mixed
     */
    public function getAllProductInCollections(array $collectionIds, int $limit = null) {
        $query = $this->model
                    ->select('products.id', 'products.name', 'products.slug', 'products.type_product', 'products.price', 'products.sale_price', 'products.image_feature', 'products.sale_start_date', 'products.sale_end_date')
                    ->leftJoin('product_collections_relation', 'products.id', '=', 'product_collections_relation.product_id')
                    ->whereIn('product_collections_relation.product_collection_id', $collectionIds)
                    ->where('products.status', true)
                    ->where('products.type_product', '!=', ProductReferenceConfig::PRODUCT_TYPE_VARIANT);
        if ($limit)
            $query = $query->limit($limit);

        return $query->distinct()->get();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getBestSellerProducts(int $limit = 8) {
        return $this->allBy([
           [
               'is_best_seller', '=', true
           ],
            [
                'type_product', '!=', ProductReferenceConfig::PRODUCT_TYPE_VARIANT
            ]
        ])->slice(0, $limit);
    }

    /**
     * @param string $keySearch
     * @param array $filterPageLoad
     * @return array|mixed
     */
    public function searchProduct(string $keySearch, array $filterPageLoad) {
        $query = $this->model
                        ->where('name', 'LIKE', "%{$keySearch}%")
                        ->orWhere('sku', 'LIKE', "%{$keySearch}%")
                        ->orWhere('keywords', 'LIKE', "%{$keySearch}%");
        $dataPageLoad = $this->getDataPageLoad($filterPageLoad);
        $result = $this->getResultSearchWithDataPageLoad($query, $dataPageLoad);
        return $result;
    }
}
