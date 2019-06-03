<?php

namespace Plugins\Product\Controllers\Web;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Plugins\Cart\Services\CartServices;
use Plugins\Payment\Requests\CheckoutPaymentRequest;
use Core\Base\Controllers\Web\BasePublicController;
use Core\Base\Responses\BaseHttpResponse;
use Plugins\Customer\Services\IOrderService;
use Plugins\Payment\Services\IPaypalCreditService;
use Plugins\Payment\Services\IPaypalRefundService;
use PayPal\Exception\PayPalConnectionException;
use Plugins\Payment\Services\IPaypalExpressService;
use Plugins\Product\Requests\CheckoutFormRequest;
use Plugins\Product\Requests\CreditFormRequest;
use Plugins\Payment\Contracts\PaymentReferenceConfig;
use Plugins\Customer\Contracts\OrderReferenceConfig;
use Plugins\Payment\Repositories\Interfaces\PaymentRepositories;

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
	 * [$paymentRepositories description]
	 * @var PaymentRepositories
	 */
	private $paymentRepositories;

	/**
	 * [$orderRepository description]
	 * @var OrderRepositories
	 */
	private $orderService;

    /**
     * @var CartServices
     */
	private $cartServices;

	/**
	 * [$paypalRefundService description]
	 * @var IPaypalRefundService
	 */
	private $paypalRefundService;

	public function __construct(
		IOrderService $orderService, 
		IPaypalCreditService $paypalCreditService,
		PaymentRepositories $paymentRepositories,
		IPaypalExpressService $paypalPaymentService,
		IPaypalRefundService $paypalRefundService,
        CartServices $cartServices)
	{
		parent::__construct();
		$this->orderService         = $orderService;
		$this->paypalCreditService  = $paypalCreditService;
		$this->paypalPaymentService = $paypalPaymentService;
		$this->paymentRepositories  = $paymentRepositories;
		$this->cartServices         = $cartServices;
		$this->paypalRefundService  = $paypalRefundService;
	}

	/**
	 * Get checkout order product of customer
	 * @param  Request $request [description]
	 * @return Illuminate\View\View
	 */
	public function getCheckout(Request $request)
	{
        $cart = $this->cartServices->getBasicInfoCartOfCustomer(Auth::guard('customer')->id());
		return view('pages.checkout.index', compact('cart'));
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
		return $this->responseAfterChargeOrder($paymentInfo, $response);
	}

	/**	
	 * [responseAfterChargeOrder description]
	 * @param  [type] $paymentInfo [description]
	 * @return [type]              [description]
	 */
	private function responseAfterChargeOrder($paymentInfo, BaseHttpResponse $response)
	{
		$transaction = $paymentInfo->transactions[0];
		$orderId = $transaction->invoice_number;

		$conditionsUpdateOrder = [
		    [
                'id', '=', $orderId
            ]
        ];

		$this->createTransactionPayment($paymentInfo);

		if(in_array($paymentInfo->state ?? '', [
			PaymentReferenceConfig::REFERENCE_PAYMENT_STATUS_CREATED,
			PaymentReferenceConfig::REFERENCE_PAYMENT_STATUS_APPROVED
		])){
			$invoiceStatus = find_reference_element(OrderReferenceConfig::REFERENCE_ORDER_STATUS_OPEN, OrderReferenceConfig::REFERENCE_ORDER_STATUS);
			//Success charge order with payment. Change status order to open here
			$dataUpdate = [
			    'status' => $invoiceStatus->id,
			    'paypal_id' => $paymentInfo->id,
            ];
			$this->orderService->updateOrder($conditionsUpdateOrder, $dataUpdate);
			return $response
				->setPreviousUrl(route('homepage'))
				->setNextUrl(route('homepage'))
                ->setMessage(trans('Your transaction Success!!! Thank your order.'));
		}

		//Failed charge order with payment. Change status order to open here
		$invoiceStatus = find_reference_element(OrderReferenceConfig::REFERENCE_ORDER_STATUS_PENDING, OrderReferenceConfig::REFERENCE_ORDER_STATUS);

        $dataUpdate = [
            'status' => $invoiceStatus->id,
            'paypal_id' => $paymentInfo->id,
        ];

        $this->orderService->updateOrder($conditionsUpdateOrder, $dataUpdate);

		return $response
				->setPreviousUrl(route('homepage'))
				->setNextUrl(route('homepage'))
				->setError()
                ->setMessage(trans('Your transaction failed!!! Please try again via history orders.'));
	}

	/**
	 * [createTransactionPayment description]
	 * @param  [type] $paymentInfo [description]
	 * @return [type]              [description]
	 */
	private function createTransactionPayment($paymentInfo)
	{
		$payer       = $paymentInfo->payer;
		$transaction = $paymentInfo->transactions[0];
		$orderId     = $transaction->invoice_number;

		return $this->paymentRepositories->createOrUpdate([
			'customer_id'    => get_current_customer()->id,
			'description'    => $transaction->description,
			'transaction_id' => $transaction->related_resources[0]->sale->id,
			'amount'         => $transaction->amount->total,
			'status'         => $paymentInfo->state,
			'payment_method' => $payer->payment_method,
			'currency'       => $transaction->amount->currency,
			'paypal_id'      => $paymentInfo->id
		]);
	}

    /**
     * @param CheckoutFormRequest $request
     * @param CreditFormRequest $creditRequest
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws \Exception
     */
	public function postCheckoutCredit(CheckoutFormRequest $request, CreditFormRequest $creditRequest, BaseHttpResponse $response)
	{
		list($address, $card)            = $this->getCreditPayloadRequest($request, $creditRequest);
		list($invoiceId, $invoiceAmount) = $this->createOrderInvoice($request, $card['cardType']);
		try{
			$paymentInfo = $this->paypalCreditService
				->setAddressAttribute($address)
				->setPaymentCardAttribute($card)
				->setItemsAttribute()
				->setAmountAttribute($invoiceAmount)
				->createPaymentCredit([], $invoiceId);
		}catch(PayPalConnectionException $paypalException){
			 return response()->json(json_decode($paypalException->getData()));
			return $response
				->setPreviousUrl(route('homepage'))
				->setNextUrl(route('homepage'))
				->setError()
                ->setMessage(trans('Your transaction failed!!! Please try again via history orders.'));
		}

		return $this->responseAfterChargeOrder($paymentInfo, $response);
	}
	/**
     * @param int $id
     * @param Request $request
     * @return BaseHttpResponse
     * @author TrinhLe
     */
    public function refundOrder(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            //TODO REFUND

            $saleId = $id;
            $paymentInfo = $this->paypalRefundService
            	->setAmountAttribute(10000)
            	->createRefundPayment($saleId);
            // TODO UPDATE ORDER here	
            return $response->setMessage(trans('Refund success your order'));
        } catch (PayPalConnectionException $ex) {
        
            return $response
                ->setError()
                ->setMessage(trans('Cannot refund order!!!'));
        }
        catch (\Exception $ex) {
            return $response
                ->setError()
                ->setMessage(trans('Cannot refund order!!!'));
        }
    }

    /**
     * @param CheckoutFormRequest $request
     * @param $paymentType
     * @return array
     * @throws \Exception
     */
	private function createOrderInvoice(CheckoutFormRequest $request, $paymentType)
	{
	    $dataCheckout = $request->all();
	    $invoiceStatus = find_reference_element(OrderReferenceConfig::REFERENCE_ORDER_STATUS_NEW, OrderReferenceConfig::REFERENCE_ORDER_STATUS);
	    $dataCheckout['invoice_status'] = ($invoiceStatus) ? $invoiceStatus->id : 0;
	    $dataCheckout['payment_method'] = $paymentType;
		$invoiceOrder = $this->orderService->createOrderCustomerProduct($dataCheckout, Auth::guard('customer')->id());


		// Invoice amount belong to discount code if exist. please countdown if used.

		// 3D free design for this invoice here

		//TODO CODE HERE FOR CREATE INVOICE

		return [$invoiceOrder['order_id'], $invoiceOrder['total_amount_order']];
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
			'cardType'           => $creditRequest->creditcard['card_name'],
			'cardNumber'         => $creditRequest->creditcard['card_number'],
			'cardExpireMonth'    => $creditRequest->creditcard['expiration_month'],
			'cardExpireYear'     => $creditRequest->creditcard['expiration_year'],
			'cardCvv'            => $creditRequest->creditcard['card_cvv'],
			'cardFirstName'      => $creditRequest->creditcard['first_name'],
			'cardLastName'       => $creditRequest->creditcard['last_name'],
			'cardBillingCountry' => 'US'
		];
		return [$address, $card];
	}

	/**
	 * [getCreditPayloadRequestTest description]
	 * @param  CheckoutFormRequest $request       [description]
	 * @param  CreditFormRequest   $creditRequest [description]
	 * @return array                             [description]
	 */
	private function getCreditPayloadRequestTest()
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
		return [$address, $card];
	}
}