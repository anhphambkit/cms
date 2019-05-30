<?php

namespace Plugins\Customer\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Plugins\Faq\Models\Faq
 *
 * @mixin \Eloquent
 */
class Order extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customer_orders';

    protected $fillable = [
		'address_billing',
		'address_shipping',
		'status',
		'amount',
		'products',
		'tracking_product_ids',
		'discount_code',
		'tracking_number',
		'payment_method',
		'transaction_id',
		'customer_signature',
		'reason_refund',
		'customer_id',
    ];
}
