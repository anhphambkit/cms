<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-13
 * Time: 21:22
 */

namespace Plugins\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Plugins\Customer\Models\Customer;

class SaveForLater extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'save_for_later';

    protected $fillable = [
        'customer_id',
        'product_id',
        'quantity',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class)->with(['productCustomAttributes', 'productStringValueAttribute']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}