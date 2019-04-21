<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-08
 * Time: 22:07
 */

namespace Plugins\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductManufacturer extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_manufacturers';

    protected $fillable = [
        'name',
        'manufacturer_image',
        'policy',
        'status',
        'created_by',
        'updated_by',
    ];
}