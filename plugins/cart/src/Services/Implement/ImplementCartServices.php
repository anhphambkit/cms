<?php
/**
 * Created by PhpStorm.
 * Customer: AnhPham
 * Date: 2019-06-02
 * Time: 08:49
 */

namespace Plugins\Cart\Services\Implement;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Plugins\Cart\Repositories\Interfaces\CartRepositories;
use Plugins\Cart\Services\CartServices;
use Plugins\Product\Repositories\Interfaces\ProductCouponRepositories;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;
use Plugins\Product\Services\ProductServices;

class ImplementCartServices implements CartServices {

    /**
     * @var CartRepositories
     */
    private $repository;

    /**
     * @var ProductServices
     */
    private $productServices;

    /**
     * @var ProductRepositories
     */
    private $productRepositories;

    /**
     * @var ProductCouponRepositories
     */
    private $productCouponRepositories;

    /**
     * ImplementCartServices constructor.
     * @param CartRepositories $cartRepositories
     * @param ProductCouponRepositories $productCouponRepositories
     * @param ProductServices $productServices
     * @param ProductRepositories $productRepositories
     */
    public function __construct(CartRepositories $cartRepositories, ProductCouponRepositories $productCouponRepositories,
                                ProductServices $productServices, ProductRepositories $productRepositories)
    {
        $this->repository = $cartRepositories;
        $this->productServices = $productServices;
        $this->productRepositories = $productRepositories;
        $this->productCouponRepositories = $productCouponRepositories;
    }

    /**
     * @param array $products
     * @param int $customerId
     * @param bool $isGuest
     * @param bool $isUpdate
     * @throws \Exception
     */
    public function addOrUpdateProductsToCartOfCustomer(array $products, int $customerId = 0, bool $isGuest = false, bool $isUpdate = false) {
        try {
            foreach ($products as $productId => $quantity) {
                $quantity = intval($quantity) > 0 ? intval($quantity) : 1;
                $this->repository->addOrUpdateProductsToCartOfCustomer(intval($productId), $quantity, $customerId, $isGuest, $isUpdate);
            }
            return;
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param int|null $customerId
     * @param bool $isGuest
     * @return array|mixed
     * @throws \Exception
     */
    public function getBasicInfoCartOfCustomer(int $customerId = null, bool $isGuest = false) {
        try {
            $products = $this->repository->getBasicInfoCartOfCustomer($customerId, $isGuest);
            $couponId = $products->pluck('coupon_id')->first();
            $coupon = $this->productCouponRepositories->findById($couponId);
            $productInCarts = $this->productRepositories->findByArrayId($products->pluck('id')->toArray(), [ 'productAttributeValues', 'productCustomAttributes' ]);
            $totalItems = $products->sum('quantity');
            $totalPrice = $this->calculatorTotalPrice($products, $coupon);
            $savedPrice = $this->calculatorSavedPrice($products, $totalPrice);
            $freeDesignIdeaInfo = $this->calculatorWantingPriceAndTotalFreeDesignIdea($totalPrice);
            return [
                'products' => $productInCarts,
                'quantities' => $products->pluck('quantity', 'id')->toArray(),
                'total_items' => $totalItems,
                'total_price' => $totalPrice,
                'saved_price' => $savedPrice,
                'free_design' => $freeDesignIdeaInfo,
                'coupon' => $coupon,
            ];
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param array $products
     * @param array $cart
     * @return array|mixed
     * @throws \Exception
     */
    public function getBasicInfoCartFromClient(array $products, array $cart) {
        try {
            $cartProducts = $this->updateProductsIntoCartList($products, $cart);
            $productIds = array_keys($cartProducts);
            $products = $this->productServices->getProductsInCartFromProductIds($productIds, $cartProducts);
            $totalItems = $products->sum('quantity');
            $totalPrice = $this->calculatorTotalPrice($products);
            return [
                'products' => $products,
                'total_items' => $totalItems,
                'total_price' => $totalPrice
            ];
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param Collection $products
     * @param null $coupon
     * @return mixed
     * @throws \Exception
     */
    public function calculatorTotalPrice(Collection $products, $coupon = null) {
        try {
            $now = Carbon::now();
            $total = $products->sum(function ($product) use ($now, $coupon) {
                $price = ($product->sale_price && ($now->lessThan($product->sale_start_date) || $now->greaterThan($product->sale_end_date))) ? $product->sale_price : $product->price;
                if ($coupon) {
                    $price = $this->getPriceAfterCoupon($coupon, $price, $product);
                }
                return $price*$product->quantity;
            });
            return $total;
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $coupon
     * @param int $price
     * @param $product
     * @return float|int
     */
    public function getPriceAfterCoupon($coupon, int $price, $product) {
        if ($coupon->is_all_product) {
            if ($coupon->coupon_type)
                $price = $price*((100-$coupon->coupon_value)/100);
            else
                $price -= $coupon->coupon_value;
        }
        else {
            $categories = $this->productRepositories->findById($product->id, ['productCategories'])->productCategories->pluck('id')->toArray();
            if (in_array($coupon->product_category, $categories)) {

                if ($coupon->coupon_type)
                    $price = $price*((100-$coupon->coupon_value)/100);
                else
                    $price -= $coupon->coupon_value;
            }
        }
        return ($price) ? $price : 0;
    }

    /**
     * @param int $totalPrice
     * @return mixed
     * @throws \Exception
     */
    public function calculatorWantingPriceAndTotalFreeDesignIdea(int $totalPrice) {
        try {
            $freeDesign = (int)floor($totalPrice/config('plugins-product.product.price_get_free_design_idea'));
            $wantingPrice = abs(config('plugins-product.product.price_get_free_design_idea') - ($totalPrice - ($freeDesign ? $freeDesign : 1)*config('plugins-product.product.price_get_free_design_idea')));
            return [
                'wanting_price' => $wantingPrice,
                'total_free_design' => $freeDesign,
            ];
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param Collection $products
     * @param int $totalPrice
     * @return int|mixed
     * @throws \Exception
     */
    public function calculatorSavedPrice(Collection $products, int $totalPrice) {
        try {
            $total = $products->sum(function ($product) {
                return $product->price*$product->quantity;
            });
            return $total - $totalPrice;
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param array $products
     * @param array $cart
     * @return array
     * @throws \Exception
     */
    public function updateProductsIntoCartList(array $products, array $cart) {
        try {
            foreach ($products as $productId => $quantity) {
                if (array_key_exists($productId, $cart)) {
                    $cart[$productId] += $quantity;
                }
                else {
                    $cart[$productId] = $quantity;
                }
            }
            return $cart;
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param int $customerId
     * @param bool $isGuest
     * @return array|mixed
     * @throws \Exception
     */
    public function getTotalItemsInCart(int $customerId, bool $isGuest = false)
    {
        try {
            $totalItems = $this->repository->getTotalItemsInCart($customerId, $isGuest);
            return $totalItems;
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param int $productId
     * @param int $customerId
     * @param bool $isGuest
     * @param bool $isUpdate
     * @return mixed
     * @throws \Exception
     */
    public function deleteProductInCart(int $productId, int $customerId = 0, bool $isGuest = false, bool $isUpdate = false) {
        try {
            return $this->repository->addOrUpdateProductsToCartOfCustomer($productId, 0, $customerId, $isGuest, $isUpdate);
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param int|null $customerId
     * @param bool $isGuest
     * @return array|mixed
     * @throws \Exception
     */
    public function getProductsInCartToOrder(int $customerId = null, bool $isGuest = false) {
        try {
            $products = $this->repository->getBasicInfoCartOfCustomer($customerId, $isGuest);
            $couponId = $products->pluck('coupon_id')->first();
            $coupon = $this->productCouponRepositories->findById($couponId);
            $totalItems = $products->sum('quantity');
            $totalPrice = $this->calculatorTotalPrice($products, $coupon);
            $totalOriginalPrice = $this->calculatorTotalOriginalPrice($products);
            $salePrice = $this->calculatorTotalSalePrice($products);
            $savedPrice = $this->calculatorSavedPrice($products, $totalPrice);
            $freeDesignIdeaInfo = $this->calculatorWantingPriceAndTotalFreeDesignIdea($totalPrice);
            $discountPrice = $totalOriginalPrice - $totalPrice - $salePrice;
            $subTotal = $totalPrice - $discountPrice;
            return [
                'products' => $products,
                'total_items' => $totalItems,
                'total_price' => $totalPrice,
                'total_original_price' => $totalOriginalPrice,
                'total_sale_price_on_products' => $salePrice,
                'saved_price' => $savedPrice,
                'total_free_design' => $freeDesignIdeaInfo['total_free_design'],
                'coupon' => $coupon,
                'discount_price' => $discountPrice,
                'sub_total' => $subTotal,
            ];
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param Collection $products
     * @return mixed
     * @throws \Exception
     */
    public function calculatorTotalOriginalPrice(Collection $products) {
        try {
            $total = $products->sum(function ($product) {
                return $product->price*$product->quantity;
            });
            return $total;
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param Collection $products
     * @return mixed
     * @throws \Exception
     */
    public function calculatorTotalSalePrice(Collection $products) {
        try {
            $total = $products->sum(function ($product) {
                $price = ($product->sale_price) ? $product->sale_price : 0;
                return $price*$product->quantity;
            });
            return $total;
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Not Work
     * @param Collection $products
     * @return mixed
     * @throws \Exception
     */
    public function calculatorAllPrice(Collection $products) {
        try {
            $total = $products->sum(function ($product) {
                $salePrice = ($product->sale_price) ? $product->sale_price : 0;
                $price = ($product->sale_price) ? $product->sale_price : $product->price;
                return [
                    "sub_total" => $product->price*$product->quantity,
                    'total_price' => $price*$product->quantity,
                    'discount_on_products' => $salePrice*$product->quantity,
                ];
            });
            return $total;
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param array $idProducts
     * @param int|null $customerId
     * @param bool $isGuest
     * @return mixed
     * @throws \Exception
     */
    public function deleteListProductInCart(array $idProducts, int $customerId = null, bool $isGuest = false) {
        return $this->repository->deleteListProductInCart($idProducts, $customerId, $isGuest);
    }

    /**
     * @param string $couponCode
     * @param int $customerId
     * @return mixed
     */
    public function addCouponToCart(string $couponCode, int $customerId) {
        $coupon = $this->productCouponRepositories->findCouponValidByCouponCode($couponCode);
        if ($coupon) {
            $this->repository->update([
                [
                    'customer_id', '=', $customerId
                ]
            ], [
                'coupon_id' => $coupon->id
            ]);
            return [
                'status' => 'success',
                'message' => "Add coupon success!"
            ];
        }
        else
            return [
                'status' => 'fail',
                'message' => "Coupon not valid!"
            ];
    }

    /**
     * @param int $couponId
     * @param int $customerId
     * @return mixed
     */
    public function deleteCouponInCart(int $couponId, int $customerId) {
        $result = $this->repository->update([
            [
                'customer_id', '=', $customerId
            ],
            [
                'coupon_id', '=', $couponId
            ]
        ], [
            'coupon_id' => null
        ]);
        if ($result)
            return [
                'status' => 'success',
                'message' => "Delete coupon success!"
            ];
        return [
            'status' => 'fail',
            'message' => "Delete coupon fail!"
        ];
    }
}