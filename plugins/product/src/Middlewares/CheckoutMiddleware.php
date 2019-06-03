<?php
namespace Plugins\Product\Middlewares;
use Closure;
use Core\Base\Responses\BaseHttpResponse;
use Plugins\Cart\Services\CartServices;

class CheckoutMiddleware 
{
    /**
     * @var CartServices
     */
    private $cartServices;

    /**
     * [__construct description]
     * @param CartServices $cartServices [description]
     */
    public function __construct(CartServices $cartServices)
    {
        $this->cartServices = $cartServices;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) 
    {
        if(setting('disable_checkout_middleware', false) || !$this->isExistCart())
            return $next($request);

        return (new BaseHttpResponse())
                ->setPreviousUrl(route('homepage'))
                ->setNextUrl(route('homepage'))
                ->setError()
                ->setMessage(trans('Your Cart is empty!!!'));
    }

    /**
     * [isExistCart description]
     * @return boolean [description]
     */
    public function isExistCart():bool
    {
        $cart = $this->cartServices->getProductsInCartToOrder(get_current_customer()->id);
        return $cart['products']->isEmpty();
    }
}