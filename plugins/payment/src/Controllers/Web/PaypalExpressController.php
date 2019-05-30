<?php
namespace Plugins\Payment\Controllers\Web;

use Illuminate\Http\Request;
use Plugins\Payment\Requests\CheckoutPaymentRequest;
use Core\Base\Controllers\Web\BasePublicController;
use Core\Base\Responses\BaseHttpResponse;
use Illuminate\Support\Facades\Session;
use Plugins\Customer\Services\IOrderService;
use Plugins\Payment\Services\IPaypalExpressService;
use PayPal\Exception\PayPalConnectionException;

class PaypalExpressController extends BasePublicController
{
	/**	
	 * [$expressProvider description]
	 * @var PayPal
	 */
	private $paypalService;

	/**
	 * [$orderRepository description]
	 * @var OrderRepositories
	 */
	private $orderService;

	public function __construct(IOrderService $orderService, IPaypalExpressService $paypalService)
	{
		parent::__construct();
		$this->orderService = $orderService;
		$this->paypalService = $paypalService;
	}	

	/**
	 * Show paypal form
	 * @author TrinhLe
	 * @param Request $request 
	 * @return Illuminate\View\View
	 */
	public function testExpressCheckout(Request $request, BaseHttpResponse $response)
	{
		try{
			$directLink = $this->paypalService
							->setReturnUrl(route('payment.paypal.express.callback'))
							->createPaymentExpress([
								'amount' => 10
							], uniqid());

		}catch(PayPalConnectionException $paypalException){
			return response()->json(json_decode($paypalException->getData()));
		}
		return redirect($directLink);
	}

	/**
	 * Show paypal form
	 * @author TrinhLe
	 * @param Request $request 
	 * @return Illuminate\View\View
	 */
	public function testExpressCheckoutCallback(Request $request, BaseHttpResponse $response)
	{
		$this->paypalService->getPaymentStatus($request);
	}
}