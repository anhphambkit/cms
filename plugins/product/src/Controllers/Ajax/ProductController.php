<?php

namespace Plugins\Product\Controllers\Ajax;

use Illuminate\Http\Request;
use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\Auth;
use Plugins\Cart\Services\CartServices;
use Plugins\Product\Services\ProductServices;

class ProductController extends BaseAdminController
{
    /**
     * @var ProductServices
     */
    protected $productServices;

    /**
     * @var CartServices
     */
    protected $cartServices;

    /**
     * ProductController constructor.
     * @param ProductServices $productServices
     */
    public function __construct(ProductServices $productServices, CartServices $cartServices)
    {
        $this->productServices = $productServices;
        $this->cartServices = $cartServices;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
	public function getOverviewInfoProductPopup(Request $request) {
	    $productId = (int)$request->product_id;
        $productInfo = $this->productServices->getOverviewInfoProductPopup($productId);
        return response()->json($productInfo);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetailInfoProductByAttributes(Request $request) {
        $productAttributes = !empty($request->get('product_attribute_info')) ? $request->get('product_attribute_info') : [];
        $productId = (int)$request->get('product_id');
        $productInfo = $this->productServices->getDetailInfoProductByProductIdAndAttribute($productId, $productAttributes);
        return response()->json($productInfo);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetailInfoProduct(Request $request) {
        $productId = (int)$request->get('product_id');
        $productInfo = $this->productServices->getDetailInfoProduct($productId);
        return response()->json($productInfo);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function addOrUpdateProductsToCartOfCustomer(Request $request) {
        $isUpdate = $request->get('is_update_product');
        $products = $request->get('products');
        $productAttributes = ($isUpdate) ? [] : $request->get('product_attributes');
        $this->cartServices->addOrUpdateProductsToCartOfCustomer($products, Auth::guard('customer')->id(), false, $isUpdate);
        $basicInfoCart = $this->cartServices->getBasicInfoCartOfCustomer(Auth::guard('customer')->id());
        return response()->json($basicInfoCart);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function addCoupon(Request $request) {
        $couponCode = strtolower(trim($request->get('coupon_code')));
        $coupon = $this->cartServices->addCouponToCart($couponCode, Auth::guard('customer')->id());
        $basicInfoCart = $this->cartServices->getBasicInfoCartOfCustomer(Auth::guard('customer')->id());
        return response()->json(array_merge($basicInfoCart, $coupon));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function addOrRemoveProductToQuickList(Request $request) {
        $entityId = (int)($request->get('entity_id'));
        $typeEntity = (string)($request->get('type_entity'));
        $result = $this->productServices->addOrRemoveProductToQuickList($entityId, Auth::guard('customer')->id(), $typeEntity);
        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function saveProductForLater(Request $request) {
        $products = $request->get('products');
        $result = $this->productServices->saveProductForLater($products, Auth::guard('customer')->id());
        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function moveProductToCart(Request $request) {
        $productId = (int)($request->get('product_id'));
        $result = $this->productServices->moveProductToCart($productId, Auth::guard('customer')->id());
        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteProductSaved(Request $request) {
        $productId = (int)($request->get('product_id'));
        $result = $this->productServices->deleteProductSaved($productId, Auth::guard('customer')->id());
        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteCouponInCart(Request $request) {
        $couponId = (int)($request->get('coupon_id'));
        $coupon = $this->cartServices->deleteCouponInCart($couponId, Auth::guard('customer')->id());
        $basicInfoCart = $this->cartServices->getBasicInfoCartOfCustomer(Auth::guard('customer')->id());
        return response()->json(array_merge($basicInfoCart, $coupon));
    }
}