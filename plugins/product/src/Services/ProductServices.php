<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 11/7/18
 * Time: 03:32
 */

namespace Plugins\Product\Services;

interface ProductServices {
    /**
     * @param array $categoryIds
     * @param int|null $limit
     * @return mixed
     * @throws \Exception
     */
    public function getAllProductsByCategory(array $categoryIds, int $limit = null);

    /**
     * @param int $productId
     * @return mixed
     */
    public function getOverviewInfoProductPopup(int $productId);

    /**
     * @param int $productId
     * @return mixed
     */
    public function getDetailInfoProduct(int $productId);

    /**
     * @param int $productId
     * @param array $productAttributes
     * @return mixed
     */
    public function getDetailInfoProductByProductIdAndAttribute(int $productId, array $productAttributes);

    /**
     * @param int $limit
     * @return mixed
     */
    public function getBestSellerProducts(int $limit = 8);

    /**
     * @param int $productCategoryId
     * @param int|null $limit
     * @param array $dataPageLoad
     * @return mixed
     */
    public function getListProductsOfCategoryPage(int $productCategoryId, int $limit = null, array $dataPageLoad = []);

    /**
     * @param int $productCategoryId
     * @param int|null $limit
     * @param array $dataPageLoad
     * @return array|mixed
     */
    public function getListProductsOfSubCategoryPage(int $productCategoryId, int $limit = null, array $dataPageLoad = []);

    /**
     * @param int $productCategoryId
     * @param int|null $limit
     * @param array $dataPageLoad
     * @return mixed
     */
    public function getListSaleProductsOfCategoryPageParent(int $productCategoryId, int $limit = null, array $dataPageLoad = []);

    /**
     * @param int $productId
     * @param int $customerId
     * @return mixed
     */
    public function addOrRemoveProductToQuickList(int $productId, int $customerId);

    /**
     * @param array $products
     * @param int $customerId
     * @return mixed
     */
    public function saveProductForLater(array $products, int $customerId);

    /**
     * @param int $productId
     * @param int $customerId
     * @return mixed
     */
    public function moveProductToCart(int $productId, int $customerId);

    /**
     * @param int $productId
     * @param int $customerId
     * @return mixed
     */
    public function deleteProductSaved(int $productId, int $customerId);

    /**
     * @param string $keySearch
     * @param array $filterPageLoad
     * @return array|mixed
     */
    public function searchProduct(string $keySearch, array $filterPageLoad);
}