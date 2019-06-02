<?php

namespace Plugins\Product\Controllers\Ajax;

use Illuminate\Http\Request;
use Core\Base\Controllers\Admin\BaseAdminController;
use Plugins\Product\Services\ProductServices;

class ProductController extends BaseAdminController
{
    /**
     * @var ProductServices
     */
    protected $productServices;

    public function __construct(ProductServices $productServices)
    {
        $this->productServices = $productServices;
    }

	public function getOverviewInfoProductPopup(Request $request) {
	    $productId = (int)$request->product_id;
        $productInfo = $this->productServices->getOverviewInfoProductPopup($productId);
        return response()->json($productInfo);
    }

    public function getDetailInfoProduct(Request $request) {
        $productAttributes = $request->product_attribute_info;
        $productId = (int)$request->product_id;
        $productInfo = $this->productServices->getDetailInfoProductByProductIdAndAttribute($productId, $productAttributes);
        return response()->json($productInfo);
    }
}