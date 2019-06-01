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
        return $this->productServices->getOverviewInfoProductPopup($productId);
    }
}