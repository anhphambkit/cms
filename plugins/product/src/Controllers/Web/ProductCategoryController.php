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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getListProductsOfCategoryPage($url, Request $request) {
        $productCategoryId = get_id_from_url($url);
        $categoryPageInfo = $this->productServices->getListProductsOfCategoryPage($productCategoryId, null, $request->all());
        $productWishListIds = $this->wishListRepositories->getArrayIdWishListProductsByCustomer((int)Auth::guard('customer')->id());
        $this->addAssetListPage();
        return view('pages.category.detail', compact('categoryPageInfo', 'productWishListIds'));
    }

    /**
     * @param $url
     * @param $subCategory
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function getListProductsOfSubCategoryPage($url, $subCategory, Request $request) {
        $productCategoryId = get_id_from_url($subCategory);
        $categoryPageInfo = $this->productServices->getListProductsOfSubCategoryPage($productCategoryId, null, $request->all());
        $productWishListIds = $this->wishListRepositories->getArrayIdWishListProductsByCustomer((int)Auth::guard('customer')->id());
        if ($request->ajax()) {
            $products = $categoryPageInfo['products'];
            $view = view('partials.list-product-items',compact('productWishListIds', 'products'))->render();
            return response()->json(['html'=>$view]);
        }
        $this->addAssetListPage();
        return view('pages.category.sub-category-detail', compact('categoryPageInfo', 'productWishListIds'));
    }

    /**
     * @param $url
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function getListSaleProductsOfCategoryPage($url, Request $request) {
        $productCategoryId = get_id_from_url($url);
        $categoryPageInfo = $this->productServices->getListSaleProductsOfCategoryPageParent($productCategoryId, null, $request->all());
        $productWishListIds = $this->wishListRepositories->getArrayIdWishListProductsByCustomer((int)Auth::guard('customer')->id());
        if ($request->ajax()) {
            $products = $categoryPageInfo['products'];
            $view = view('partials.list-product-items',compact('productWishListIds', 'products'))->render();
            return response()->json(['html'=>$view]);
        }
        $this->addAssetListPage();
        return view('pages.category.sale-category', compact('categoryPageInfo', 'productWishListIds'));
    }

    /**
     * Add assets page
     */
    public function addAssetListPage() {
        AssetManager::addAsset('product-detail-js', 'frontend/plugins/product/assets/js/product-detail.js');
        AssetPipeline::requireJs('product-detail-js');
        AssetManager::addAsset('auto-scroll-loading-product-js', 'frontend/plugins/product/assets/js/auto-scroll-loading-product.js');
        AssetPipeline::requireJs('auto-scroll-loading-product-js');
        AssetManager::addAsset('product-detail-css', 'frontend/plugins/product/assets/css/product-detail.css');
        AssetPipeline::requireCss('product-detail-css');
    }
}