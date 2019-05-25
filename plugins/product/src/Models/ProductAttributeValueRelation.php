<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-25
 * Time: 20:03
 */

namespace Plugins\Product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeValueRelation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_attribute_value_relations';

    protected $fillable = [
        'product_id',
        'attribute_id',
        'attribute_value_id',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the look book that owns the look book tag.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}