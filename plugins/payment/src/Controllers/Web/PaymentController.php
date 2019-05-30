<?php
namespace Plugins\Payment\Controllers\Web;

use Illuminate\Http\Request;
use Plugins\Payment\Requests\CheckoutPaymentRequest;
use Core\Base\Controllers\Web\BasePublicController;
use Core\Base\Responses\BaseHttpResponse;
use Illuminate\Support\Facades\Session;
use Plugins\Customer\Services\IOrderService;
use PayPalSrmklive;

class PaymentController extends BasePublicController
{
	/**	
	 * [$expressProvider description]
	 * @var PayPal
	 */
	private $expressProvider;

	/**
	 * [$orderRepository description]
	 * @var OrderRepositories
	 */
	private $orderService;

	public function __construct(IOrderService $orderService)
	{
		parent::__construct();
		$this->orderService = $orderService;
		$this->expressProvider = PayPalSrmklive::setProvider('express_checkout');
	}	

	/**
	 * Show paypal form
	 * @author TrinhLe
	 * @param Request $request 
	 * @return Illuminate\View\View
	 */
	public function showPaypalForm(CheckoutPaymentRequest $request)
	{
		// $order = $this->orderService->createOrderCustomerProduct([]);

		$data['invoice_id'] = uniqid();
		$data['items'] = [];
		$data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
		$data['return_url'] = route('payment.paypal.callback');
		$data['cancel_url'] = route('homepage');

		// $total = 0;
		// foreach($data['items'] as $item) {
		//     $total += $item['price']*$item['qty'];
		// }

		$data['total'] = 1000;

		// //give a discount of 10% of the order amount
		$data['shipping_discount'] = round((10 / 100) * 1000, 2);

		$response = $this->expressProvider->setExpressCheckout($data);
		
		Session::put('paypal_payment_token', $response['TOKEN']);

		return redirect($response['paypal_link']);
	}

	/**
	 * [callbackPaypalForm description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function callbackPaypalForm(Request $request, BaseHttpResponse $response)
	{
		// $sessionPaypalToken = session('paypal_payment_token');
		// if(!$sessionPaypalToken) return $response->setPreviousUrl(route('homepage'));

		// $response = $this->expressProvider->getExpressCheckoutDetails($request->token);
		// echo "<pre>"; 
		// 	print_r($response); 
		// echo "</pre>"; die;

	}

	/**
	 * [webhookSale description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function webhookSale(Request $request)
	{
		\Log::info('success');
	}
}