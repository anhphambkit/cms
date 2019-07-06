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
use Plugins\Product\Contracts\ProductReferenceConfig;

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
        'entity_id',
        'entity_type'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function entity()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}