<?php
namespace Core\Page\Controllers\Web;
use Core\Base\Controllers\Web\BasePublicController;
use Illuminate\Http\Request;

/**
 * Public controller frontend
 * @author TrinhLe
 */
class PublicController extends BasePublicController{

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
		return view('pages.design-ideal.index');
	}

	/**
	 * [pageDesignIdeal show]
	 * @param  Request $request [description]
	 * @return Illuminate\View\View
	 */
	public function pageDesignIdealList(Request $request)
	{
		return view('pages.design-ideal.list');
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