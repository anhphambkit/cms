<?php

namespace Plugins\Product\Controllers\Web;
use Illuminate\Http\Request;
use Core\Base\Controllers\Web\BasePublicController;
use Illuminate\Support\Facades\Auth;
use Plugins\Product\Repositories\Interfaces\WishListRepositories;
use Plugins\Product\Services\ProductServices;
use AssetManager;
use AssetPipeline;

class ProductController extends BasePublicController
{
    /**
     * @var ProductServices
     */
    protected $productServices;

    /**
     * @var WishListRepositories
     */
    protected $wishListRepositories;

    /**
     * ProductController constructor.
     * @param ProductServices $productServices
     * @param WishListRepositories $wishListRepositories
     */
    public function __construct(ProductServices $productServices, WishListRepositories $wishListRepositories)
    {
        $this->productServices = $productServices;
        $this->wishListRepositories = $wishListRepositories;
    }

    /**
     * @param $url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function getProductDetail($url) {
        $productId = get_id_from_url($url);
        $productInfo = $this->productServices->getDetailInfoProduct($productId);
        $productWishListIds = $this->wishListRepositories->getArrayIdWishListProductsByCustomer((int)Auth::guard('customer')->id());
        AssetManager::addAsset('product-detail-js', 'frontend/plugins/product/assets/js/product-detail.js');
        AssetPipeline::requireJs('product-detail-js');
        AssetManager::addAsset('product-detail-css', 'frontend/plugins/product/assets/css/product-detail.css');
        AssetPipeline::requireCss('product-detail-css');
        return view('pages.product.detail', compact('productInfo', 'productWishListIds'));
    }
}