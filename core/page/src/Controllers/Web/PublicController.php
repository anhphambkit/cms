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
     * PublicController constructor.
     */
    public function __construct()
    {
        parent::__construct();
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
}