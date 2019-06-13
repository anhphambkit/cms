<?php

namespace Plugins\Cart\Controllers\Web;
use Illuminate\Http\Request;
use Core\Base\Controllers\Web\BasePublicController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Plugins\Cart\Services\CartServices;
use AssetManager;
use AssetPipeline;
use Plugins\Product\Repositories\Interfaces\SaveForLaterRepositories;

class CartController extends BasePublicController
{
    /**
     * @var CartServices
     */
    protected $cartServices;

    /**
     * @var SaveForLaterRepositories
     */
    protected $saveForLaterRepositories;

    /**
     * CartController constructor.
     * @param CartServices $cartServices
     * @param SaveForLaterRepositories $saveForLaterRepositories
     */
    public function __construct(CartServices $cartServices, SaveForLaterRepositories $saveForLaterRepositories)
    {
        parent::__construct();
        $this->cartServices = $cartServices;
        $this->saveForLaterRepositories = $saveForLaterRepositories;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cart() {
        $customerId = Auth::guard('customer')->id();
        $cart = $this->cartServices->getBasicInfoCartOfCustomer($customerId);
        $savedProducts = $this->saveForLaterRepositories->allBy([
            [
                'customer_id', '=', $customerId
            ]
        ], ['product']);
        AssetManager::addAsset('cart-css', 'frontend/plugins/cart/assets/css/cart.css');
        AssetPipeline::requireCss('cart-css');
        AssetManager::addAsset('cart-js', 'frontend/plugins/cart/assets/js/cart.js');
        AssetPipeline::requireJs('cart-js');
        AssetManager::addAsset('cart-coupon-js', 'frontend/plugins/cart/assets/js/cart-coupon.js');
        AssetPipeline::requireJs('cart-coupon-js');
        return view('pages.cart.index', compact('cart', 'savedProducts'));
    }
}