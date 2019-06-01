<?php

namespace Plugins\Payment\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Plugins\Payment\Models\Payment
 *
 * @mixin \Eloquent
 */
class Payment extends Eloquent
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payment_transactions';

    protected $fillable = [
    	'customer_id',
		'description',
		'transaction_id',
		'amount',
		'status',
		'payment_type',
		'last_4',
		'payment_method',
		'currency',
		'paypal_id'
    ];
}
