<?php

namespace Plugins\Product\Controllers\Web;
use Illuminate\Http\Request;
use Core\Base\Controllers\Web\BasePublicController;
use Illuminate\Support\Facades\Auth;
use Plugins\Product\Repositories\Interfaces\WishListRepositories;
use Plugins\Review\Repositories\Interfaces\ReviewRepositories;
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
     * @var ReviewRepositories
     */
    protected $reviewRepository;

    /**
     * ProductController constructor.
     * @param ProductServices $productServices
     * @param WishListRepositories $wishListRepositories
     */
    public function __construct(ProductServices $productServices, WishListRepositories $wishListRepositories, ReviewRepositories $reviewRepository)
    {
        $this->productServices      = $productServices;
        $this->wishListRepositories = $wishListRepositories;
        $this->reviewRepository     = $reviewRepository;
    }

    /**
     * @param $url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
	public function getProductDetail($url) {
        $productId = get_id_from_url($url);
        $productInfo = $this->productServices->getDetailInfoProductPage($productId);

        AssetManager::addAsset('product-detail-js', 'frontend/plugins/product/assets/js/product-detail.js');
        AssetPipeline::requireJs('product-detail-js');
        AssetManager::addAsset('product-detail-css', 'frontend/plugins/product/assets/css/product-detail.css');
        AssetPipeline::requireCss('product-detail-css');

        try{
            $reviews = $this->reviewRepository->allBy([
                'product_id' => $productInfo['product']->id
            ], ['comments', 'customer']);
        }
        catch(\Exception $ex){
            info($ex->getMessage());
            $reviews = [];
        }

        return view('pages.product.detail', compact('productInfo', 'reviews'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Throwable
     */
    public function searchProduct(Request $request) {
	    $keySearch = trim($request->get('search'));
	    if (empty($keySearch))
	        return redirect(route('homepage'));

        $products = $this->productServices->searchProduct($keySearch, $request->all());

//        if ($request->ajax()) {
//            $products = $products['data'];
//            $view = view('partials.list-product-items',compact('products'))->render();
//            return response()->json(['html'=>$view]);
//        }
        $this->addAssetListPage();
        return view('pages.product.list-search-products', compact('keySearch', 'products'));
    }

    /**
     * Add assets page
     */
    public function addAssetListPage() {
        AssetManager::addAsset('product-detail-js', 'frontend/plugins/product/assets/js/product-detail.js');
        AssetPipeline::requireJs('product-detail-js');
//        AssetManager::addAsset('auto-scroll-loading-product-js', 'frontend/plugins/product/assets/js/auto-scroll-loading-product.js');
//        AssetPipeline::requireJs('auto-scroll-loading-product-js');
        AssetManager::addAsset('product-detail-css', 'frontend/plugins/product/assets/css/product-detail.css');
        AssetPipeline::requireCss('product-detail-css');
    }
}