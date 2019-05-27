<?php
namespace Plugins\Payment\Controllers\Web;

use Illuminate\Http\Request;
use Plugins\Payment\Requests\CheckoutPaymentRequest;
use Core\Base\Controllers\Web\BasePublicController;
use Core\Base\Responses\BaseHttpResponse;
use Illuminate\Support\Facades\Session;
use Plugins\Customer\Services\IOrderService;
use Plugins\Payment\Services\IPaypalCreditService;
use PayPal\Exception\PayPalConnectionException;

class PaypalCreditController extends BasePublicController
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

	public function __construct(IOrderService $orderService, IPaypalCreditService $paypalService)
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
	public function testCreditCard(Request $request, BaseHttpResponse $response)
	{
		$address  = [
			'address1'    => '3909 Witmer Road',
			'address2'    => 'Niagara Falls',
			'city'        => 'Niagara Falls',
			'state'       => 'NY',
			'postalCode'  => 14305,
			'countryCode' => 'US',
			'phone'       => '716-298-1822',
		];

		$card = [
			'cardType'           => 'visa',
			'cardNumber'         => '4669424246660779',
			'cardExpireMonth'    => '11',
			'cardExpireYear'     => '2019',
			'cardCvv'            => '012',
			'cardFirstName'      => 'Joe',
			'cardLastName'       => 'Shopper',
			'cardBillingCountry' => 'US',
		];

		try{
			$result = $this->paypalService
				->setAddressAttribute($address)
				->setPaymentCardAttribute($card)
				->setItemsAttribute()
				->setAmountAttribute(12)
				->createPaymentCredit([], uniqid());
		}catch(PayPalConnectionException $paypalException){
			return response()->json(json_decode($paypalException->getData()));
		}

		return $result;
	}
}