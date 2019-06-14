<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-13
 * Time: 20:43
 */

namespace Plugins\Product\Controllers\Web;

use Core\Base\Controllers\Web\BasePublicController;
use Illuminate\Support\Facades\Auth;
use Plugins\Product\Repositories\Interfaces\WishListRepositories;
use AssetManager;
use AssetPipeline;

class WishListController extends BasePublicController
{
    /**
     * @var WishListRepositories
     */
    protected $wishListRepositories;

    /**
     * WishListController constructor.
     * @param WishListRepositories $wishListRepositories
     */
    public function __construct(WishListRepositories $wishListRepositories)
    {
        $this->wishListRepositories = $wishListRepositories;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProductWishList() {
        $customerId = (int)Auth::guard('customer')->id();
        $wishListProducts = $this->wishListRepositories->allBy([
            [
                'customer_id', '=', $customerId
            ]
        ], ['product'], ['*']);
        $productWishListIds = $this->wishListRepositories->getArrayIdWishListProductsByCustomer($customerId);
        AssetManager::addAsset('product-detail-js', 'frontend/plugins/product/assets/js/product-detail.js');
        AssetPipeline::requireJs('product-detail-js');
        AssetManager::addAsset('product-detail-css', 'frontend/plugins/product/assets/css/product-detail.css');
        AssetPipeline::requireCss('product-detail-css');
        return view('pages.wish-list.wish-list', compact('wishListProducts', 'productWishListIds'));
    }
}