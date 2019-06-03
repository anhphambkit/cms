<?php
namespace Core\Page\Controllers\Web;
use Core\Base\Controllers\Web\BasePublicController;
use Illuminate\Http\Request;
use Plugins\Product\Services\ProductServices;

/**
 * Public controller frontend
 * @author TrinhLe
 */
class PublicController extends BasePublicController{

    /**
     * @var ProductServices
     */
    private $productServices;

    /**
     * PublicController constructor.
     * @param ProductServices $productServices
     */
    public function __construct(ProductServices $productServices)
    {
        parent::__construct();
        $this->productServices = $productServices;
    }

    /**
	 * [homepage description]
	 * @param  Request $request [description]
	 * @return Illuminate\View\View
	 */
	public function homepage(Request $request)
	{
        page_title()->setTitle('Ifoss');
        $bestSellerProducts = $this->productServices->getBestSellerProducts(8);
		return view('homepage', compact('bestSellerProducts'));
	}
}