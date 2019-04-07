<?php

namespace Plugins\Customer\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Plugins\Customer\Models\Customer
 *
 * @mixin \Eloquent
 */
class Customer extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customers';

    protected $fillable = ['name'];
}
