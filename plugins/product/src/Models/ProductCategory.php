<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-13
 * Time: 05:13
 */

namespace Plugins\Product\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'order',
        'status',
        'is_root',
    ];
}