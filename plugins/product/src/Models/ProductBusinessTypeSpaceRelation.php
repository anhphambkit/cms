<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-25
 * Time: 19:46
 */

namespace Plugins\Product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBusinessTypeSpaceRelation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_business_type_space_relation';

    protected $fillable = [
        'business_type_id',
        'space_id',
        'product_id',
        'apply_all',
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