<?php

namespace Plugins\Payment\Services;

interface IPaypalExpressService
{
	/**
     * [createPaymentCredit description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function createPaymentExpress(array $data = [], $invoiceId);

    /**
     * Set return URL
     *
     * @param string $url Return URL for payment process complete
     * @return self
     */
    public function setReturnUrl($url);
}