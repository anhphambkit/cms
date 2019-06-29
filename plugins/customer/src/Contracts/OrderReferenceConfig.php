<?php
namespace Plugins\Customer\Contracts;

interface OrderReferenceConfig
{
	/* Reference order status */
	const REFERENCE_ORDER_STATUS           = 'ORDER_STATUS';
	const REFERENCE_ORDER_STATUS_NEW       = 'New';
	const REFERENCE_ORDER_STATUS_PENDING   = 'Pending';
	const REFERENCE_ORDER_STATUS_OPEN      = 'Open';
	const REFERENCE_ORDER_STATUS_SHIPPED   = 'Shipped';
	const REFERENCE_ORDER_STATUS_CANCEL    = 'Cancel';
	const REFERENCE_ORDER_STATUS_REFUND    = 'Refund';
	const REFERENCE_ORDER_STATUS_DELIVERED = 'Delivered';

	const REFERENCE_ORDER_DISPLAY_STATUS_NEW       = 'New';
	const REFERENCE_ORDER_DISPLAY_STATUS_PENDING   = 'Pending';
	const REFERENCE_ORDER_DISPLAY_STATUS_OPEN      = 'Open';
	const REFERENCE_ORDER_DISPLAY_STATUS_SHIPPED   = 'Shipped';
	const REFERENCE_ORDER_DISPLAY_STATUS_CANCEL    = 'Cancel';
	const REFERENCE_ORDER_DISPLAY_STATUS_REFUND    = 'Refunded';
	const REFERENCE_ORDER_DISPLAY_STATUS_DELIVERED = 'Delivered';
}