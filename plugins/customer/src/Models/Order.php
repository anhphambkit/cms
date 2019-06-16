<?php

namespace Plugins\Customer\Models;

use Illuminate\Database\Eloquent\Model;
use Plugins\Product\Models\Product;
use Plugins\Customer\Models\ProductsInOrder;

/**
 * Class Order
 * @package Plugins\Customer\Models
 */
class Order extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customer_orders';

    protected $fillable = [
        'customer_id',
        'is_guest',
        'address_billing',
        'address_shipping',
        'shipping_method',
        'payment_method',
        'total_original_price',
        'total_amount_order',
        'discount_price',
        'shipping_fee',
        'total_price',
        'total_sale_price_on_products',
        'saved_price',
        'coupon_code',
        'is_free_shipping',
        'status',
        'tracking_product_ids',
        'tracking_number',
        'transaction_id',
        'customer_signature',
        'reason_refund',
        'amount_refund',
        'payment_id',
        'paypal_id',
        'total_free_design',
    ];

    /**
     * [products description]
     * @return [type] [description]
     */
    public function products()
    {
        return $this->hasMany(ProductsInOrder::class, 'order_id');
    }
}
