<?php
namespace Core\Page\Controllers\Web;
use Core\Base\Controllers\Web\BasePublicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\Product\Repositories\Interfaces\WishListRepositories;
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
     * @var WishListRepositories
     */
    private $wishListRepositories;

    /**
     * PublicController constructor.
     * @param ProductServices $productServices
     * @param WishListRepositories $wishListRepositories
     */
    public function __construct(ProductServices $productServices, WishListRepositories $wishListRepositories)
    {
        $this->productServices = $productServices;
        $this->wishListRepositories = $wishListRepositories;
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
        $productWishListIds = $this->wishListRepositories->getArrayIdWishListProductsByCustomer(Auth::guard('customer')->id());
		return view('homepage', compact('bestSellerProducts', 'productWishListIds'));
	}
}