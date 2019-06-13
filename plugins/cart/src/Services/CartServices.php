<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-02
 * Time: 08:48
 */

namespace Plugins\Cart\Services;

use Illuminate\Database\Eloquent\Collection;

interface CartServices
{
    /**
     * @param array $products
     * @param int $customerId
     * @param bool $isGuest
     * @param bool $isUpdate
     * @throws \Exception
     */
    public function addOrUpdateProductsToCartOfCustomer(array $products, int $customerId = 0, bool $isGuest = false, bool $isUpdate = true);

    /**
     * @param int|null $customerId
     * @param bool $isGuest
     * @return mixed
     */
    public function getBasicInfoCartOfCustomer(int $customerId = null, bool $isGuest = false);

    /**
     * @param array $products
     * @param array $cart
     * @return mixed
     */
    public function getBasicInfoCartFromClient(array $products, array $cart);

    /**
     * @param Collection $products
     * @return mixed
     * @throws \Exception
     */
    public function calculatorTotalPrice(Collection $products);

    /**
     * @param array $products
     * @param array $cart
     * @return array
     * @throws \Exception
     */
    public function updateProductsIntoCartList(array $products, array $cart);

    /**
     * @param int $customerId
     * @param bool $isGuest
     * @return mixed
     */
    public function getTotalItemsInCart(int $customerId, bool $isGuest = false);

    /**
     * @param int $productId
     * @param int $customerId
     * @param bool $isGuest
     * @param bool $isUpdate
     * @return mixed
     */
    public function deleteProductInCart(int $productId, int $customerId = 0, bool $isGuest = false, bool $isUpdate = true);

    /**
     * @param int|null $customerId
     * @param bool $isGuest
     * @return mixed
     */
    public function getProductsInCartToOrder(int $customerId = null, bool $isGuest = false);

    /**
     * @param array $idProducts
     * @param int|null $customerId
     * @param bool $isGuest
     * @return mixed
     */
    public function deleteListProductInCart(array $idProducts, int $customerId = null, bool $isGuest = false);

    /**
     * @param string $couponCode
     * @param int $customerId
     * @return mixed
     */
    public function addCouponToCart(string $couponCode, int $customerId);

    /**
     * @param int $couponId
     * @param int $customerId
     * @return mixed
     */
    public function deleteCouponInCart(int $couponId, int $customerId);
}