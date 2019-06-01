<?php

namespace Plugins\Payment\Contracts;

interface PaymentReferenceConfig
{
	/* Reference payment status */
	const REFERENCE_PAYMENT_STATUS          = 'PAYMENT_STATUS';
	const REFERENCE_PAYMENT_STATUS_CREATED  = 'created';
	const REFERENCE_PAYMENT_STATUS_APPROVED = 'approved';
	const REFERENCE_PAYMENT_STATUS_FAILED   = 'failed';

	/* Reference payment type */
	const REFERENCE_PAYMENT_TYPE             = 'PAYMENT_TYPE';
	const REFERENCE_PAYMENT_TYPE_PAYPAL      = 'Paypal';
	const REFERENCE_PAYMENT_TYPE_CREDIT_CARD = 'Credit Card';

	const REFERENCE_PAYMENT_PAYPAL_CARD_NAME          = 'PAYMENT_PAYPAL_CARD_NAME';
	const REFERENCE_PAYMENT_PAYPAL_CARD_NAME_VISA     = 'visa';
	const REFERENCE_PAYMENT_PAYPAL_CARD_NAME_MASTER   = 'mastercard';
	const REFERENCE_PAYMENT_PAYPAL_CARD_NAME_DISCOVER = 'discover';
	const REFERENCE_PAYMENT_PAYPAL_CARD_NAME_AMEX     = 'amex';
}