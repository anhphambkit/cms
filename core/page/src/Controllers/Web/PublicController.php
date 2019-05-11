<?php
namespace Core\Page\Controllers\Web;
use Core\Base\Controllers\Web\BasePublicController;
use Illuminate\Http\Request;
use Plugins\Product\Contracts\ProductReferenceConfig;
use Plugins\Product\Services\BusinessTypeServices;
use Plugins\Product\Services\LookBookServices;
use AssetManager;
use AssetPipeline;
use Plugins\Product\Services\ProductSpaceServices;

/**
 * Public controller frontend
 * @author TrinhLe
 */
class PublicController extends BasePublicController{

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
     * PublicController constructor.
     * @param BusinessTypeServices $businessTypeServices
     * @param LookBookServices $lookBookServices
     * @param ProductSpaceServices $productSpaceServices
     */
    public function __construct(BusinessTypeServices $businessTypeServices, LookBookServices $lookBookServices, ProductSpaceServices $productSpaceServices)
    {
        $this->businessTypeServices = $businessTypeServices;
        $this->lookBookServices = $lookBookServices;
        $this->productSpaceServices = $productSpaceServices;
    }

    /**
	 * [homepage description]
	 * @param  Request $request [description]
	 * @return Illuminate\View\View
	 */
	public function homepage(Request $request)
	{
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
        $listRender = $this->lookBookServices->getBlockRenderLookBook(1);
        AssetManager::addAsset('look-book-design-css', 'frontend/plugins/product/assets/css/look-book-design.css');
        AssetPipeline::requireCss('look-book-design-css');
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

        $businessTypeName = $businessTypeModel->name;

	    $spaces = $this->businessTypeServices->getAllSpacesByBusinessTypeBySlug($businessType);

        $listRender = $this->lookBookServices->getBlockRenderLookBook(0, $businessTypeModel->id, $spaceModel->id);

//        dd($listRender);

        return view('pages.design-ideal.list', compact('listRender'));
	}

    /**
     * @param $businessType
     * @param Request $request
     */
	public function pageAllRoomsDesignIdealOfBusinessType($businessType, Request $request) {
        $businessTypeModel = $this->businessTypeServices->getBusinessTypeBySlug($businessType);

        if (!$businessTypeModel)
            abort(404);

//        dd($businessTypeModel);
    }

	/**
	 * [pageDesignIdeal show]
	 * @param  Request $request [description]
	 * @return Illuminate\View\View
	 */
	public function pageDesignIdealList(Request $request)
	{
        AssetManager::addAsset('look-book-design-css', 'frontend/plugins/product/assets/css/look-book-design.css');
        AssetPipeline::requireCss('look-book-design-css');

        $listRender = $this->lookBookServices->getBlockRenderLookBook();

		return view('pages.design-ideal.list', compact('listRender'));
	}

	/**
	 * [pageDesignIdeal show]
	 * @param  Request $request [description]
	 * @return Illuminate\View\View
	 */
	public function pageDesignIdealDetail(Request $request)
	{
		return view('pages.design-ideal.detail');
	}
}