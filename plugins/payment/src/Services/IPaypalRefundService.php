<?php

namespace Plugins\Payment\Services;

interface IPaypalRefundService
{
	/**
     * [createPaymentCredit description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function createRefundPayment($saleId, array $data = []);

    /**
     * [setAmountAttribute description]
     * @param [type] $amount [description]
     */
    public function setAmountAttribute($amount, array $amountDetails = []);
}