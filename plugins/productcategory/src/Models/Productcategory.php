<?php

namespace Plugins\Productcategory\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Plugins\Productcategory\Models\Productcategory
 *
 * @mixin \Eloquent
 */
class Productcategory extends Eloquent
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'productcategory';

    protected $fillable = ['name'];
}
