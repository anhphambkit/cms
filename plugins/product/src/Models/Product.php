<?php

namespace Plugins\Product\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Plugins\Product\Models\Product
 *
 * @mixin \Eloquent
 */
class Product extends Eloquent
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'upc',
        'sku',
        'image_feature',
        'short_description',
        'long_desc',
        'is_feature',
        'is_best_seller',
        'is_free_ship',
        'has_design',
        'has_assembly',
        'product_dimension',
        'package_dimension',
        'product_weight',
        'package_weight',
        'price',
        'sale_price',
        'in_stock',
        'rating',
        'keywords',
        'status',
    ];
}
