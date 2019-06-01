<?php

namespace Plugins\Product\Controllers\Web;
use Illuminate\Http\Request;
use Core\Base\Controllers\Web\BasePublicController;

class ProductController extends BasePublicController
{
	public function getProductDetail($url, Request $request) {
        $productId = get_id_from_url($url);
        dd($productId);
    }
}