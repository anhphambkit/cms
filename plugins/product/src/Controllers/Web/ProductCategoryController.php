<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-07
 * Time: 14:03
 */

namespace Plugins\Product\Controllers\Web;
use Illuminate\Http\Request;
use Core\Base\Controllers\Web\BasePublicController;
use Illuminate\Support\Facades\Auth;
use Plugins\Product\Repositories\Interfaces\WishListRepositories;
use Plugins\Product\Services\ProductServices;
use AssetManager;
use AssetPipeline;

class ProductCategoryController extends BasePublicController
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
     * ProductCategoryController constructor.
     * @param ProductServices $productServices
     * @param WishListRepositories $wishListRepositories
     */
    public function __construct(ProductServices $productServices, WishListRepositories $wishListRepositories)
    {
        parent::__construct();
        $this->productServices = $productServices;
        $this->wishListRepositories = $wishListRepositories;
    }

    /**
     * @param $url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getListProductsOfCategoryPage($url) {
        $productCategoryId = get_id_from_url($url);
        $categoryPageInfo = $this->productServices->getListProductsOfCategoryPage($productCategoryId);
        AssetManager::addAsset('product-detail-js', 'frontend/plugins/product/assets/js/product-detail.js');
        AssetPipeline::requireJs('product-detail-js');
        AssetManager::addAsset('product-detail-css', 'frontend/plugins/product/assets/css/product-detail.css');
        AssetPipeline::requireCss('product-detail-css');
        $productWishListIds = $this->wishListRepositories->getArrayIdWishListProductsByCustomer(Auth::guard('customer')->id());
        if (empty($categoryPageInfo['category']->parent_id))
            return view('pages.category.detail', compact('categoryPageInfo', 'productWishListIds'));
        else
            return view('pages.category.sub-category-detail', compact('categoryPageInfo', 'productWishListIds'));
    }

    /**
     * @param $url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getListSaleProductsOfCategoryPage($url) {
        $productCategoryId = get_id_from_url($url);
        $categoryPageInfo = $this->productServices->getListProductsOfCategoryPage($productCategoryId);
        $productWishListIds = $this->wishListRepositories->getArrayIdWishListProductsByCustomer(Auth::guard('customer')->id());
        AssetManager::addAsset('product-detail-js', 'frontend/plugins/product/assets/js/product-detail.js');
        AssetPipeline::requireJs('product-detail-js');
        AssetManager::addAsset('product-detail-css', 'frontend/plugins/product/assets/css/product-detail.css');
        AssetPipeline::requireCss('product-detail-css');
        return view('pages.category.sale-category', compact('categoryPageInfo', 'productWishListIds'));
    }
}