<?php

namespace Plugins\Cart\Controllers\Ajax;

use Illuminate\Http\Request;
use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\Auth;
use Plugins\Cart\Services\CartServices;

class CartController extends BaseAdminController
{
    /**
     * @var CartServices
     */
    protected $cartServices;

    /**
     * CartController constructor.
     * @param CartServices $cartServices
     */
    public function __construct(CartServices $cartServices)
    {
        $this->cartServices = $cartServices;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
	public function updateProductsInCartOfCustomer(Request $request) {
        $isUpdate = $request->get('is_update_product');
        $products = $request->get('products');
        $this->cartServices->addOrUpdateProductsToCartOfCustomer($products, Auth::guard('customer')->id(), false, $isUpdate);
        $basicInfoCart = $this->cartServices->getBasicInfoCartOfCustomer(Auth::guard('customer')->id());
        return response()->json($basicInfoCart);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteProductInCart(Request $request) {
        $productId = $request->get('product_id');
        $this->cartServices->deleteProductInCart($productId, Auth::guard('customer')->id(), false, true);
        $basicInfoCart = $this->cartServices->getBasicInfoCartOfCustomer(Auth::guard('customer')->id());
        return response()->json($basicInfoCart);
    }
}