<?php

namespace Plugins\Customer\Services\Excute;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Plugins\Cart\Services\CartServices;
use Plugins\Customer\Services\IOrderService;
use Plugins\Customer\Repositories\Interfaces\OrderRepositories;
use Plugins\Customer\Services\IProductsInOrderServices;
use Plugins\Product\Repositories\Interfaces\ProductCouponRepositories;

class OrderService implements IOrderService
{
    /**
     * @var OrderRepositories
     */
	private $orderRepository;

    /**
     * @var CartServices
     */
	private $cartServices;

    /**
     * @var IProductsInOrderServices
     */
	private $productsInOrderServices;

    /**
     * @var ProductCouponRepositories
     */
	private $productCouponRepositories;

    /**
     * OrderService constructor.
     * @param OrderRepositories $orderRepository
     * @param CartServices $cartServices
     * @param IProductsInOrderServices $productsInOrderServices
     * @param ProductCouponRepositories $productCouponRepositories
     */
	public function __construct(OrderRepositories $orderRepository, CartServices $cartServices, IProductsInOrderServices $productsInOrderServices, ProductCouponRepositories $productCouponRepositories)
	{
        $this->orderRepository         = $orderRepository;
        $this->cartServices            = $cartServices;
        $this->productsInOrderServices = $productsInOrderServices;
        $this->productCouponRepositories = $productCouponRepositories;
	}

    /**
     * @param array $dataCheckouts
     * @param int $customerId
     * @param bool $isGuest
     * @return mixed
     * @throws \Exception
     */
    public function createOrderCustomerProduct(array $dataCheckouts, int $customerId, bool $isGuest = false){
        $now = Carbon::now();
        // Current Cart:
        $cart = $this->cartServices->getProductsInCartToOrder($customerId);

        if ($cart['products']->isEmpty())
            abort(404, 'cart not empty');
        // Get fee shipping:
        $shippingFee = 0;

        // Prepare data for create new order
        $dataOrder = [
            'customer_id'                  => $customerId,
            'is_guest'                     => $isGuest,
            'address_shipping'             => json_encode($dataCheckouts['address_shipping']),
            'address_billing'              => json_encode($dataCheckouts['address_billing']),
            'payment_method'               => $dataCheckouts['payment_method'],
            'total_original_price'         => $cart['total_original_price'],
            'discount_price'               => $cart['discount_price'],
            'total_sale_price_on_products' => $cart['total_sale_price_on_products'],
            'saved_price'                  => $cart['saved_price'],
            'coupon_code'                  => $cart['coupon'] ? $cart['coupon']->code : null,
            'total_price'                  => $cart['sub_total'],
            'total_amount_order'           => $cart['total_price'] + $shippingFee,
            'shipping_fee'                 => $shippingFee,
            'is_free_shipping'             => ($shippingFee > 0) ? false : true,
            'updated_at'                   => $now,
            'created_at'                   => $now,
            'status'                       => $dataCheckouts['invoice_status'],
        ];
        $couponId = $cart['coupon'] ? $cart['coupon']->id : null;

        return DB::transaction(function () use ($dataOrder, $cart, $customerId, $couponId, $isGuest) {
            // Create new Order:
            $orderId = $this->orderRepository->createNewInvoiceOrder($dataOrder);
            // Products:
            $productsInOder = $this->prepareProductsDataInOrder($cart['products']->toArray(), $orderId);
            // Insert products in cart to order:
            $this->productsInOrderServices->insertProductsInOrder($productsInOder['products']);
            // Delete products in cart:
            $this->cartServices->deleteListProductInCart($productsInOder['id_products'], $customerId, false);
            // Update number use of coupon:
            if ($couponId) {
                $this->productCouponRepositories->updateNumberUseOfCoupon($couponId);
            }
            return [
                'order_id'           => $orderId,
                'total_amount_order' => $dataOrder['total_amount_order']
            ];
        }, 3);
    }

    /**
     * @param array $products
     * @param int $orderId
     * @return array
     * @throws \Exception
     */
    public function prepareProductsDataInOrder(array $products, int $orderId) {
        try {
            $now = Carbon::now();
            $idProducts = [];
            foreach ($products as $index => $product) {
                $products[$index]['order_id'] = $orderId;
                $products[$index]['product_id'] = $product['id'];
                $products[$index]['categories'] = "";
                $products[$index]['updated_at'] = $now;
                $products[$index]['created_at'] = $now;
                $idProducts[] = $product['id'];
                unset($products[$index]['id'], $products[$index]['coupon_id'], $products[$index]['sale_start_date'], $products[$index]['sale_end_date']);
            }
            return [
                'products' => $products,
                'id_products' => $idProducts
            ];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param array $conditions
     * @param array $data
     * @return mixed
     */
    public function updateOrder(array $conditions, array $data) {
        return $this->orderRepository->update($conditions, $data);
    }

    /**
     * [getMyOrders description]
     * @param  [type] $customerId [description]
     * @return [type]             [description]
     */
    public function getMyOrders(int $customerId)
    {
        return $this->orderRepository->allBy(['customer_id' => $customerId]);
    }

    /**
     * [findOrderCustomer description]
     * @param  array  $conditions [description]
     * @return [type]             [description]
     */
    public function findOrderCustomer(array $conditions = [])
    {
        $conditions = array_merge($conditions,[
            'customer_id'  => get_current_customer()->id
        ]);
        $order = $this->orderRepository->getFirstBy($conditions);
        return $order ?? abort(404, 'notfound');
    }
}