<?php

namespace Plugins\Payment\Services;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\Payer;
use PayPal\Api\Details;
use PayPal\Api\PaymentExecution;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Address;
use PayPal\Api\PaymentCard;
class PaypalCreditService implements IPaypalCreditService
{
    /**
     * [$apiContext description]
     * @var [type]
     */
    private $apiContext;

    /**
     * [$paymentCurrency description]
     * @var [type]
     */
    private $paymentCurrency;

    /**
     * [$totalAmount description]
     * @var [type]
     */
    private $totalAmount;

    /**
     * @var [type]
     * [$returnUrl description]
     */
    private $returnUrl;

    /**
     * [$cancelUrl description]
     * @var [type]
     */
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
     * [setAddressAttribute description]
     * @param array $data [description]
     */
    public function setAddressAttribute(array $data)
    {
        $this->address = new Address();
        $this->address
            ->setLine1($data['address1'] ?? '')
            ->setLine2($data['address2'] ?? '')
            ->setCity($data['city'] ?? '')
            ->setState($data['state'] ?? '')
            ->setPostalCode($data['postalCode'] ?? '')
            ->setCountryCode($data['countryCode'] ?? 'US')
            ->setPhone($data['phone'] ?? '');
        return $this;
    }

    /**
     * [setPaymentCard description]
     * @param array $data [description]
     */
    public function setPaymentCardAttribute(array $data)
    {
        $this->paymentCredit = new PaymentCard();
        $this->paymentCredit
            ->setType($data['cardType'] ?? 'visa')
            ->setNumber($data['cardNumber'])
            ->setExpireMonth($data['cardExpireMonth'])
            ->setExpireYear($data['cardExpireYear'])
            ->setCvv2($data['cardCvv'])
            ->setFirstName($data['cardFirstName'])
            ->setLastName($data['cardLastName'])
            ->setBillingCountry($data['cardBillingCountry'] ?? 'US')
            ->setBillingAddress($this->address);

        return $this;
    }

    /**
     * [setItems description]
     * @param array $data [description]
     */
    public function setItemsAttribute(array $products = [])
    {
        $this->listItems = new ItemList();
        foreach ($products as $product) {
            # code...
            $item = new Item();
            $item->setName($product['name'])
            ->setDescription($product['description'] ?? '')
            ->setCurrency($this->paymentCurrency)
            ->setQuantity($product['quantity'])
            ->setTax($product['tax'] ?? 0)
            ->setPrice($product['price']);
            $this->listItems->addItem($item);
            $item = null;
        }
        return $this;
    }

    /**
     * [setAmountAttribute description]
     * @param [type] $amount [description]
     */
    public function setAmountAttribute($amount, array $amountDetails = [])
    {
        if($amountDetails){
            $details = new Details();
            $details->setShipping($amountDetails['shipping'] ?? 0)
                ->setTax($amountDetails['tax'] ?? 0)
                ->setSubtotal($amountDetails['subtotal'] ?? 0);
        }
            
        $this->totalAmount = new Amount();
        $this->totalAmount
            ->setCurrency($this->paymentCurrency)
            ->setTotal($amount)
            ->setDetails($details ?? new Details());
        return $this;
    }

    /**
     * [createPaymentCredit description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function createPaymentCredit(array $data = [], $invoiceId)
    {
        $funding = new FundingInstrument();
        $funding->setPaymentCard($this->paymentCredit);

        $payer = new Payer();
        $payer->setPaymentMethod('credit_card')
              ->setFundingInstruments(array($funding));

        $transaction = new Transaction();
        $transaction->setAmount($this->totalAmount)
            ->setItemList($this->listItems)
            ->setDescription($data['transactionDescription'] ?? 'Payment description')
            ->setInvoiceNumber($invoiceId);

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setTransactions([$transaction]);

        try {
            $response = $payment->create($this->apiContext);
        } catch (PayPalConnectionException $paypalException) {
            throw $paypalException;
        }
        return $response;
    }
}