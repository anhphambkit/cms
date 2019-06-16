<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-03
 * Time: 09:00
 */

namespace Plugins\Customer\Models;


use Illuminate\Database\Eloquent\Model;

class ProductsInOrder extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products_in_order';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'slug',
        'sku',
        'image_feature',
        'categories',
        'medias',
        'price',
        'sale_price',
        'quantity',
    ];

    public $timestamps = true;

    /**
     * [getCategoriesAttribute description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function getCategoriesAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * [getMediasAttribute description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function getMediasAttribute($value)
    {
        return json_decode($value, true);
    }
}