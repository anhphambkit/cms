<?php

namespace Plugins\Productlookbook\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Plugins\Productlookbook\Models\Productlookbook
 *
 * @mixin \Eloquent
 */
class Productlookbook extends Eloquent
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'productlookbook';

    protected $fillable = ['name'];
}
