<?php

namespace Plugins\Payment\Models;
use Plugins\Customer\Models\Customer;
use Eloquent;

/**
 * Plugins\Payment\Models\Payment
 *
 * @mixin \Eloquent
 */
class Payment extends Eloquent
{
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

    /**	
     * [customer description]
     * @return [type] [description]
     */
    public function customer()
    {
    	return $this->belongsTo(Customer::class, 'customer_id');
    }
}
