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
    protected $table = 'product';

    protected $fillable = ['name'];
}
