<?php

namespace Plugins\Payment\Services;

use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\Payer;
use PayPal\Api\PaymentExecution;
use Request;

class PaypalExpressService implements IPaypalExpressService
{
	private $apiContext;
    private $paymentCurrency;
    private $totalAmount;
    private $returnUrl;
    private $cancelUrl;

    public function __construct()
    {
        $paypalConfigs = config('paypal');
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $paypalConfigs['client_id'],
                $paypalConfigs['secret']
            )
        );
        $this->paymentCurrency = $paypalConfigs['currency'];
        $this->totalAmount = 0;
    }

    /**
     * Set payment currency
     *
     * @param string $currency String name of currency
     * @return self
     */
    public function setCurrency($currency)
    {
        $this->paymentCurrency = $currency;

        return $this;
    }

    /**
     * Get current payment currency
     *
     * @return string Current payment currency
     */
    public function getCurrency()
    {
        return $this->paymentCurrency;
    }

    public function getapiContext()
    {
        return $this->apiContext;
    }

    /**
     * Set return URL
     *
     * @param string $url Return URL for payment process complete
     * @return self
     */
    public function setReturnUrl($url)
    {
        $this->returnUrl = $url;

        return $this;
    }

    /**
     * Get return URL
     *
     * @return string Return URL
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * Get total amount
     *
     * @return mixed Total amount
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Set cancel URL
     *
     * @param $url Cancel URL for payment
     * @return self
     */
    public function setCancelUrl($url)
    {
        $this->cancelUrl = $url;

        return $this;
    }

    /**
     * Get cancel URL of payment
     *
     * @return string Cancel URL
     */
    public function getCancelUrl()
    {
        return $this->cancelUrl;
    }

    /**
     * [createPaymentCredit description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function createPaymentExpress(array $data = [], $invoiceId)
    {
        $approveLink = false;

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $transactionDescription = isset($data['transaction_description']) ? $data['transaction_description'] : '';

        $amount = new Amount();
        $amount->setCurrency($this->paymentCurrency)
            ->setTotal($data['amount']);

        // Transaction
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription($transactionDescription);

        $redirectUrls = new RedirectUrls();

        if (is_null($this->cancelUrl)) {
            $this->cancelUrl = $this->returnUrl;
        }

        $redirectUrls->setReturnUrl($this->returnUrl)
            ->setCancelUrl($this->cancelUrl);

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        // create payment
        try {
            $payment->create($this->apiContext);
        } catch (PayPalConnectionException $paypalException) {
            throw new \Exception($paypalException->getMessage());
        }

        session()->put('paypal_payment_id', $payment->id);

        return $payment->getApprovalLink();
    }

    /**
     * Get payment status
     *
     * @return mixed Object payment details or false
     */
    public function getPaymentStatus($request)
    {
		$payment          = Payment::get($request->paymentId, $this->apiContext);
		$paymentExecution = new PaymentExecution();
		$paymentExecution->setPayerId($request->PayerID);
		$paymentStatus    = $payment->execute($paymentExecution, $this->apiContext);
        return $paymentStatus;
    }
}