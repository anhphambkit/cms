<?php
namespace Core\Page\Controllers\Web;
use Core\Base\Controllers\Web\BasePublicController;
use Illuminate\Http\Request;
use Plugins\Product\Contracts\ProductReferenceConfig;
use Plugins\Product\Services\BusinessTypeServices;
use Plugins\Product\Services\LookBookServices;
use AssetManager;
use AssetPipeline;

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
     * PublicController constructor.
     * @param BusinessTypeServices $businessTypeServices
     * @param LookBookServices $lookBookServices
     */
    public function __construct(BusinessTypeServices $businessTypeServices, LookBookServices $lookBookServices)
    {
        $this->businessTypeServices = $businessTypeServices;
        $this->lookBookServices = $lookBookServices;
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
		return view('pages.design-ideal.index', compact('businessTypes'));
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