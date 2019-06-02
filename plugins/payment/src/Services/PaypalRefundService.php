<?php

namespace Plugins\Payment\Services;

use PayPal\Api\Amount;
use PayPal\Api\Refund;
use PayPal\Api\Sale;

class PaypalRefundService extends BasePaymentService implements IPaypalRefundService
{
	public function __construct(){
        parent::__construct();
    }

    /**
     * [createPaymentCredit description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function createRefundPayment($saleId, array $data = [])
    {
    	$sale = new Sale();
		$sale->setId($saleId);

		try {
		  	$response = $sale->refund($this->refund, $this->apiContext);
		  	
		} catch (PayPal\Exception\PayPalConnectionException $ex) {
		  throw $ex;
		} catch (Exception $ex) {
		  throw $ex;
		}
		return $response;
    }

    /**
     * [setAmountAttribute description]
     * @param [type] $amount [description]
     */
    public function setAmountAttribute($amount, array $amountDetails = [])
    {
    	$this->totalAmount = new Amount();
		$this->totalAmount->setTotal($amount)
		  ->setCurrency($amountDetails['currency'] ?? 'USD');
		$this->refund = new Refund();
		$this->refund->setAmount($this->totalAmount);
		return $this;
    }
}