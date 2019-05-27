<?php

namespace Plugins\Payment\Services;

interface IPaypalCreditService
{
	/**
     * [createPaymentCredit description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function createPaymentCredit(array $data = [], $invoiceId);

	/**
     * [setAddressAttribute description]
     * @param array $data [description]
     */
    public function setAddressAttribute(array $data);

    /**
     * [setPaymentCard description]
     * @param array $data [description]
     */
    public function setPaymentCardAttribute(array $data);

    /**
     * [setAmountAttribute description]
     * @param [type] $amount [description]
     */
    public function setAmountAttribute($amount, array $amountDetails = []);

    /**
     * [setItems description]
     * @param array $data [description]
     */
    public function setItemsAttribute(array $products = []);
}