<?php
namespace Core\Page\Controllers\Web;
use Core\Base\Controllers\Web\BasePublicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\Product\Repositories\Interfaces\WishListRepositories;
use Plugins\Product\Services\ProductServices;
use SeoHelper;

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
        SeoHelper::setTitle('Ifoss Homepage')
                    ->setDescription('Ifoss homepage ne');
        $bestSellerProducts = $this->productServices->getBestSellerProducts(8);
		return view('homepage', compact('bestSellerProducts'));
	}
}