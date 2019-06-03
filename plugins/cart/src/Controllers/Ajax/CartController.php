<?php

namespace Plugins\Cart\Controllers\Ajax;

use Illuminate\Http\Request;
use Core\Base\Controllers\Admin\BaseAdminController;

class CartController extends BaseAdminController
{
    /**
     * @var CartServices
     */
    protected $cartServices;

    /**
     * ProductController constructor.
     * @param ProductServices $productServices
     */
    public function __construct(CartServices $cartServices)
    {
        $this->productServices = $productServices;
        $this->cartServices = $cartServices;
    }

	public function updateProductsInCartOfCustomer(Request $request) {
        $products = $request->get('products');
        $this->cartServices->addOrUpdateProductsToCartOfCustomer($products, Auth::guard('customer')->id(), false);
        $basicInfoCart = $this->cartServices->getBasicInfoCartOfCustomer(Auth::guard('customer')->id());
        return response()->json($basicInfoCart);
    }
}