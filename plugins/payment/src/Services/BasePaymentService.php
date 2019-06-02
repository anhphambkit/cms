<?php

namespace Plugins\Payment\Services;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class BasePaymentService
{
    /**
     * [$apiContext description]
     * @var [type]
     */
    protected $apiContext;

    /**
     * [$paymentCurrency description]
     * @var [type]
     */
    protected $paymentCurrency;

    /**
     * [$totalAmount description]
     * @var [type]
     */
    protected $totalAmount;

    /**
     * @var [type]
     * [$returnUrl description]
     */
    protected $returnUrl;

    /**
     * [$cancelUrl description]
     * @var [type]
     */
    protected $cancelUrl;

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
}


    