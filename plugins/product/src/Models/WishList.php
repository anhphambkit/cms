<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-13
 * Time: 19:13
 */

namespace Plugins\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Plugins\Customer\Models\Customer;

class WishList extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wish_list';

    protected $fillable = [
        'customer_id',
        'product_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}