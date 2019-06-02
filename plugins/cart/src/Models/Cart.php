<?php

namespace Plugins\Cart\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cart
 * @package Plugins\Cart\Models
 */
class Cart extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cart';

    protected $fillable = [
        'customer_id',
        'product_id',
        'quantity',
        'is_guest',
        'order',
    ];
}
