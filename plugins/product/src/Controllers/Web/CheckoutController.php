<?php

namespace Plugins\Product\Controllers\Web;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Plugins\Payment\Requests\CheckoutPaymentRequest;
use Core\Base\Controllers\Web\BasePublicController;
use Core\Base\Responses\BaseHttpResponse;
use Plugins\Customer\Services\IOrderService;
use Plugins\Payment\Services\IPaypalCreditService;
use PayPal\Exception\PayPalConnectionException;
use Plugins\Payment\Services\IPaypalExpressService;
use Plugins\Product\Requests\CheckoutFormRequest;
use Plugins\Product\Requests\CreditFormRequest;
use Plugins\Payment\Contracts\PaymentReferenceConfig;
use Plugins\Customer\Contracts\OrderReferenceConfig;

class CheckoutController extends BasePublicController
{	
	/**
	 * [$checkoutRepository description]
	 * @var [type]
	 */
	private $checkoutRepository;

	/**	
	 * [$expressProvider description]
	 * @var PayPal
	 */
	private $paypalCreditService;

	/**	
	 * [$expressProvider description]
	 * @var PayPal
	 */
	private $paypalPaymentService;

	/**
	 * [$orderRepository description]
	 * @var OrderRepositories
	 */
	private $orderService;

	public function __construct(
		IOrderService $orderService, 
		IPaypalCreditService $paypalCreditService,
		IPaypalExpressService $paypalPaymentService)
	{
		parent::__construct();
		$this->orderService         = $orderService;
		$this->paypalCreditService  = $paypalCreditService;
		$this->paypalPaymentService = $paypalPaymentService;
	}	

	/**
	 * Get checkout order product of customer
	 * @param  Request $request [description]
	 * @return Illuminate\View\View
	 */
	public function getCheckout(Request $request)
	{
		return view('pages.checkout.index');
	}

	/**
	 * Direct checkout with paypal checkout
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function postCheckout(CheckoutFormRequest $request)
	{
		//TODO CREATE INVOICE ORDER HERE TO GET ORDER_ID WITH PAYMENT TYPE "PAYPAL"

		$paymentType   = PaymentReferenceConfig::REFERENCE_PAYMENT_TYPE_PAYPAL;
		list($invoiceId, $invoiceAmount) = $this->createOrderInvoice($request, $paymentType);

		// DIRECT PAYPAL PAYMENT
		try{
			$directLink = $this->paypalPaymentService
							->setReturnUrl(route('public.product.checkout.paypal.callback'))
							->setCancelUrl(route('homepage'))
							->createPaymentExpress([
								'amount' => $invoiceAmount
							], $invoiceId);

		}catch(PayPalConnectionException $paypalException){
			return response()->json(json_decode($paypalException->getData()), 400);
		}
		return redirect($directLink);
	}

	/**
	 * Get callback transaction from paypal
	 * @param  Request $request [description]
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function callbackPaypalForm(Request $request, BaseHttpResponse $response)
	{
		$paymentInfo = $this->paypalPaymentService->getPaymentStatus($request);
		// Get transation payment
		$transaction = $paymentInfo->transactions[0];
		$orderId = $transaction->invoice_number;

		if(in_array($transaction->state ?? '', [
			PaymentReferenceConfig::REFERENCE_PAYMENT_STATUS_CREATED,
			PaymentReferenceConfig::REFERENCE_PAYMENT_STATUS_APPROVED
		])){
			
			$invoiceStatus = find_reference_element(OrderReferenceConfig::REFERENCE_ORDER_STATUS_OPEN, OrderReferenceConfig::REFERENCE_ORDER_STATUS);
			//Success charge order with payment. Change status order to open here
			return $response
				->setPreviousUrl(route('homepage'))
				->setNextUrl(route('homepage'))
                ->setMessage(trans('Your transaction Success!!! Thank your order.'));
		}

		//Failed charge order with payment. Change status order to open here
		$invoiceStatus = find_reference_element(OrderReferenceConfig::REFERENCE_ORDER_STATUS_PENDING, OrderReferenceConfig::REFERENCE_ORDER_STATUS);

		return $response
				->setPreviousUrl(route('homepage'))
				->setNextUrl(route('homepage'))
				->setError()
                ->setMessage(trans('Your transaction failed!!! Please try again via history orders.'));
	}

	/**
	 * Checkout order with credit card same payment paypal checkout
	 * @param  CheckoutFormRequest $request  [description]
	 * @param  BaseHttpResponse    $response [description]
	 * @return Illuminate\View\View
	 */
	public function postCheckoutCredit(CheckoutFormRequest $request, CreditFormRequest $creditRequest, BaseHttpResponse $response)
	{
		list($address, $card) = $this->getCreditPayloadRequest($request, $creditRequest);

		list($invoiceId, $invoiceAmount) = $this->createOrderInvoice($request, $card['cardType']);

		try{
			$result = $this->paypalCreditService
				->setAddressAttribute($address)
				->setPaymentCardAttribute($card)
				->setItemsAttribute()
				->setAmountAttribute($invoiceAmount)
				->createPaymentCredit([], $invoiceId);
		}catch(PayPalConnectionException $paypalException){
			return response()->json(json_decode($paypalException->getData()));
		}

		return $result;
	}

	/**
	 * Create invoice
	 * @param  CheckoutFormRequest $request     [description]
	 * @param  [type]              $paymentType [description]
	 * @return array
	 */
	private function createOrderInvoice(CheckoutFormRequest $request, $paymentType)
	{
		$invoiceStatus = find_reference_element(OrderReferenceConfig::REFERENCE_ORDER_STATUS_NEW, OrderReferenceConfig::REFERENCE_ORDER_STATUS);
		$invoiceId     = uniqid();
		$invoiceAmount = 1000;

		// Invoice amount belong to discount code if exist. please countdown if used.

		// 3D free design for this invoice here

		//TODO CODE HERE FOR CREATE INVOICE

		return [$invoiceId, $invoiceAmount];
	}

	/**
	 * Get payload request for payment credit
	 * @param  CheckoutFormRequest $request       [description]
	 * @param  CreditFormRequest   $creditRequest [description]
	 * @return array
	 */
	private function getCreditPayloadRequest(CheckoutFormRequest $request, CreditFormRequest $creditRequest)
	{
		$address  = [
			'address1'    => $request->address_billing['address_1'],
			'address2'    => $request->address_billing['address_2'],
			'city'        => $request->address_billing['city'],
			'state'       => $request->address_billing['state'],
			'postalCode'  => $request->address_billing['zip'],
			'countryCode' => 'US',
			'phone'       => $request->address_billing['phone_number'],
		];

		$card = [
			'cardType'           => $creditRequest->card_name,
			'cardNumber'         => $creditRequest->card_name,
			'cardExpireMonth'    => $creditRequest->expiration_month,
			'cardExpireYear'     => $creditRequest->expiration_year,
			'cardCvv'            => $creditRequest->card_cvv,
			'cardFirstName'      => $creditRequest->first_name,
			'cardLastName'       => $creditRequest->last_name,
			'cardBillingCountry' => 'US'
		];
		return [$address, $card];
	}
}