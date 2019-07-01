<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-01
 * Time: 00:02
 */

namespace Plugins\Product\Controllers\Web;
use Core\Base\Controllers\Web\BasePublicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;
use Plugins\Product\Repositories\Interfaces\WishListRepositories;
use Plugins\Product\Services\BusinessTypeServices;
use Plugins\Product\Services\LookBookServices;
use AssetManager;
use AssetPipeline;
use Plugins\Product\Services\ProductSpaceServices;

/**
 * Public controller frontend
 * @author TrinhLe
 */
class DesignIdeaController extends BasePublicController{

    /**
     * @var BusinessTypeServices
     */
    protected $businessTypeServices;

    /**
     * @var LookBookServices
     */
    protected $lookBookServices;

    /**
     * @var ProductSpaceServices
     */
    protected $productSpaceServices;

    /**
     * @var WishListRepositories
     */
    protected $wishListRepositories;

    /**
     * @var ProductRepositories
     */
    protected $productRepositories;

    /**
     * DesignIdeaController constructor.
     * @param BusinessTypeServices $businessTypeServices
     * @param LookBookServices $lookBookServices
     * @param ProductSpaceServices $productSpaceServices
     * @param ProductRepositories $productRepositories
     * @param WishListRepositories $wishListRepositories
     */
    public function __construct(BusinessTypeServices $businessTypeServices, LookBookServices $lookBookServices,
                                ProductSpaceServices $productSpaceServices, ProductRepositories $productRepositories,
                                WishListRepositories $wishListRepositories)
    {
        parent::__construct();
        $this->businessTypeServices = $businessTypeServices;
        $this->lookBookServices = $lookBookServices;
        $this->productSpaceServices = $productSpaceServices;
        $this->wishListRepositories = $wishListRepositories;
        $this->productRepositories = $productRepositories;
    }

    /**
     * [homepage description]
     * @param  Request $request [description]
     * @return Illuminate\View\View
     */
    public function homepage(Request $request)
    {
        page_title()->setTitle('Ifoss');
        return view('homepage');
    }

    /**
     * [pageDesignIdeal show]
     * @param  Request $request [description]
     * @return Illuminate\View\View
     */
    public function pageDesignIdeal(Request $request)
    {
        $businessTypes = $this->businessTypeServices->getAllBusinessTypeGroupByParent();
        $listRender = $this->lookBookServices->getBlockRenderLookBook(1, [], [], [0], false);
        AssetManager::addAsset('look-book-design-css', 'frontend/plugins/product/assets/css/look-book-design.css');
        AssetPipeline::requireCss('look-book-design-css');
        AssetManager::addAsset('design-idea-js', 'frontend/plugins/product/assets/js/design-idea.js');
        AssetPipeline::requireJs('design-idea-js');
        return view('pages.design-ideal.index', compact('businessTypes', 'listRender'));
    }

    /**
     * @param $businessType
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pageDesignIdealOfBusinessType($businessType, Request $request)
    {
        $businessTypeModel = $this->businessTypeServices->getBusinessTypeBySlug($businessType);

        if (!$businessTypeModel)
            abort(404);

        AssetManager::addAsset('look-book-design-css', 'frontend/plugins/product/assets/css/look-book-design.css');
        AssetPipeline::requireCss('look-book-design-css');
        AssetManager::addAsset('design-idea-js', 'frontend/plugins/product/assets/js/design-idea.js');
        AssetPipeline::requireJs('design-idea-js');
        $businessTypeName = $businessTypeModel->name;

        $spaces = $this->businessTypeServices->getAllSpacesByBusinessTypeBySlug($businessType);

        $listRender = $this->lookBookServices->getBlockRenderLookBook(1);

        return view('pages.design-ideal.design-space', compact('spaces', 'businessTypeName', 'businessType', 'listRender'));
    }

    /**
     * @param $businessType
     * @param $space
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pageDesignIdealOfSpace($businessType, $space, Request $request)
    {
        $businessTypeModel = $this->businessTypeServices->getBusinessTypeBySlug($businessType);

        $spaceModel = $this->productSpaceServices->getSpaceBySlug($space);

        if (!$businessTypeModel || !$spaceModel)
            abort(404);

        AssetManager::addAsset('look-book-design-css', 'frontend/plugins/product/assets/css/look-book-design.css');
        AssetPipeline::requireCss('look-book-design-css');
        AssetManager::addAsset('design-idea-js', 'frontend/plugins/product/assets/js/design-idea.js');
        AssetPipeline::requireJs('design-idea-js');
        $businessTypeName = $businessTypeModel->name;

        $spaces = $this->businessTypeServices->getAllSpacesByBusinessTypeBySlug($businessType);

        $spaceName = $spaceModel->name;

        $listRender = $this->lookBookServices->getBlockRenderLookBook(0, [0, $businessTypeModel->id], [$spaceModel->id]);

        return view('pages.design-ideal.list', compact('listRender', 'businessType', 'businessTypeName', 'spaceName', 'spaces'));
    }

    /**
     * @param $businessType
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pageAllRoomsDesignIdealOfBusinessType($businessType, Request $request) {
        $businessTypeModel = $this->businessTypeServices->getBusinessTypeBySlug($businessType);

        if (!$businessTypeModel)
            abort(404);

        $businessTypeName = $businessTypeModel->name;
        $spaces = $this->businessTypeServices->getAllSpacesByBusinessTypeBySlug($businessType);
        $spaceName = 'All Rooms';

        AssetManager::addAsset('look-book-design-css', 'frontend/plugins/product/assets/css/look-book-design.css');
        AssetPipeline::requireCss('look-book-design-css');

        AssetManager::addAsset('design-idea-js', 'frontend/plugins/product/assets/js/design-idea.js');
        AssetPipeline::requireJs('design-idea-js');

        $listRender = $this->lookBookServices->getBlockRenderLookBook(0, [0, $businessTypeModel->id]);

        return view('pages.design-ideal.list', compact('listRender', 'businessType', 'businessTypeName', 'spaceName', 'spaces'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pageDesignIdealList(Request $request)
    {
        AssetManager::addAsset('look-book-design-css', 'frontend/plugins/product/assets/css/look-book-design.css');
        AssetPipeline::requireCss('look-book-design-css');
        AssetManager::addAsset('design-idea-js', 'frontend/plugins/product/assets/js/design-idea.js');
        AssetPipeline::requireJs('design-idea-js');
        $listRender = $this->lookBookServices->getBlockRenderLookBook();

        return view('pages.design-ideal.list', compact('listRender'));
    }

    /**
     * @param $url
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProductDesignIdea($url, Request $request)
    {
        $productId = get_id_from_url($url);
        $product = $this->productRepositories->findById($productId);
        if (!$product)
            abort(404);

        AssetManager::addAsset('look-book-design-css', 'frontend/plugins/product/assets/css/look-book-design.css');
        AssetPipeline::requireCss('look-book-design-css');
        AssetManager::addAsset('design-idea-js', 'frontend/plugins/product/assets/js/design-idea.js');
        AssetPipeline::requireJs('design-idea-js');
        $listRender = $this->lookBookServices->getBlockRenderLookBook(0, [], [], [], true, [$productId]);

        return view('pages.design-ideal.product-design-idea', compact('listRender', 'product'));
    }

    /**
     * @param $url
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pageDetailDesignIdea($url, Request $request)
    {
        $lookBookId = get_id_from_url($url);
        $lookBook = $this->lookBookServices->getDetailLookBook($lookBookId);

        AssetManager::addAsset('look-book-design-css', 'frontend/plugins/product/assets/css/look-book-design.css');
        AssetPipeline::requireCss('look-book-design-css');
        AssetManager::addAsset('design-idea-js', 'frontend/plugins/product/assets/js/design-idea.js');
        AssetPipeline::requireJs('design-idea-js');
        return view('pages.design-ideal.detail', compact('lookBook'));
    }
}
