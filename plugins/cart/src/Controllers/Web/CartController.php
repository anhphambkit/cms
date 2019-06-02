<?php

namespace Plugins\Cart\Controllers\Web;
use Illuminate\Http\Request;
use Core\Base\Controllers\Web\BasePublicController;
use Illuminate\Support\Facades\Auth;
use Plugins\Cart\Services\CartServices;

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
        $this->cartServices = $cartServices;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cart() {
        $cart = $this->cartServices->getBasicInfoCartOfCustomer(Auth::guard('customer')->id());
        return view('pages.cart.index', compact('cart'));
    }
}