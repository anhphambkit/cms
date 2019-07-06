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
        'type_entity'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'id', 'entity_id')->where('type_entity', ProductReferenceConfig::ENTITY_TYPE_PRODUCT);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lookBook()
    {
        return $this->belongsTo(LookBook::class, 'id', 'entity_id')->where('type_entity', ProductReferenceConfig::ENTITY_TYPE_LOOK_BOOK);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}