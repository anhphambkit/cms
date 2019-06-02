<?php
/**
 * Created by PhpStorm.
 * Customer: AnhPham
 * Date: 2019-06-02
 * Time: 08:49
 */

namespace Plugins\Cart\Services\Implement;

use Illuminate\Database\Eloquent\Collection;
use Plugins\Cart\Repositories\Interfaces\CartRepositories;
use Plugins\Cart\Services\CartServices;
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
     * ImplementCartServices constructor.
     * @param CartRepositories $cartRepositories
     * @param ProductServices $productServices
     * @param ProductRepositories $productRepositories
     */
    public function __construct(CartRepositories $cartRepositories, ProductServices $productServices, ProductRepositories $productRepositories)
    {
        $this->repository = $cartRepositories;
        $this->productServices = $productServices;
        $this->productRepositories = $productRepositories;
    }

    /**
     * @param array $products
     * @param int $customerId
     * @param bool $isGuest
     * @param bool $isUpdate
     * @throws \Exception
     */
    public function addOrUpdateProductsToCartOfCustomer(array $products, int $customerId = 0, bool $isGuest = true, bool $isUpdate = true) {
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
    public function getBasicInfoCartOfCustomer(int $customerId = null, bool $isGuest = true) {
        try {
            $products = $this->repository->getBasicInfoCartOfCustomer($customerId, $isGuest);
            $productInCarts = $this->productRepositories->findByArrayId($products->pluck('id')->toArray(), [ 'productAttributeValues', 'productCustomAttributes' ]);
            $totalItems = $products->sum('quantity');
            $totalPrice = $this->calculatorTotalPrice($products);
            $savedPrice = $this->calculatorSavedPrice($products, $totalPrice);
            $freeDesignIdeaInfo = $this->calculatorWantingPriceAndTotalFreeDesignIdea($totalPrice);
            return [
                'products' => $productInCarts,
                'total_items' => $totalItems,
                'total_price' => $totalPrice,
                'saved_price' => $savedPrice,
                'free_design' => $freeDesignIdeaInfo,
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
     * @return mixed
     * @throws \Exception
     */
    public function calculatorTotalPrice(Collection $products) {
        try {
            $total = $products->sum(function ($product) {
                $price = ($product->is_has_sale) ? $product->sale_price : $product->price;
                return $price*$product->quantity;
            });
            return $total;
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param int $totalPrice
     * @return mixed
     * @throws \Exception
     */
    public function calculatorWantingPriceAndTotalFreeDesignIdea(int $totalPrice) {
        try {
            $freeDesign = (int)floor($totalPrice/config('plugins-product.product.price_get_free_design_idea'));
            $wantingPrice = abs($totalPrice - ($freeDesign ? $freeDesign : 1)*config('plugins-product.product.price_get_free_design_idea'));
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
     * @return mixed
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
    public function getTotalItemsInCart(int $customerId, bool $isGuest = true)
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
    public function deleteProductInCart(int $productId, int $customerId = 0, bool $isGuest = true, bool $isUpdate = true) {
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
    public function getProductsInCartToOrder(int $customerId = null, bool $isGuest = true) {
        try {
            $products = $this->repository->getBasicInfoCartOfCustomer($customerId, $isGuest);
            $totalItems = $products->sum('quantity');
            $totalPrice = $this->calculatorTotalPrice($products);
            $subTotal = $this->calculatorTotalOriginalPrice($products);
            $salePrice = $this->calculatorTotalSalePrice($products);
            return [
                'products' => $products,
                'total_items' => $totalItems,
                'total_price' => $totalPrice,
                'sub_total' => $subTotal,
                'discount_on_products' => $salePrice,
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
    public function deleteListProductInCart(array $idProducts, int $customerId = null, bool $isGuest = true) {
//        try {
        return $this->repository->deleteListProductInCart($idProducts, $customerId, $isGuest);
//        } catch (\Exception $e) {
//            throw new \Exception($e->getMessage());
//        }
    }
}