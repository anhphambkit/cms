<?php

namespace Plugins\Cart\Controllers\Web;
use Illuminate\Http\Request;
use Core\Base\Controllers\Web\BasePublicController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Plugins\Cart\Services\CartServices;
use AssetManager;
use AssetPipeline;

class CartController extends BasePublicController
{
    /**
     * @var CartServices
     */
    protected $cartServices;

    /**
     * CartController constructor.
     * @param CartServices $cartServices
     */
    public function __construct(CartServices $cartServices)
    {
        parent::__construct();
        $this->cartServices = $cartServices;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cart() {
        $cart = $this->cartServices->getBasicInfoCartOfCustomer(Auth::guard('customer')->id());
        AssetManager::addAsset('cart-css', 'frontend/plugins/cart/assets/css/cart.css');
        AssetPipeline::requireCss('cart-css');
        AssetManager::addAsset('cart-js', 'frontend/plugins/cart/assets/js/cart.js');
        AssetPipeline::requireJs('cart-js');
        return view('pages.cart.index', compact('cart'));
    }
}