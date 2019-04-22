<?php

namespace Plugins\Payment\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Plugins\Payment\Models\Payment
 *
 * @mixin \Eloquent
 */
class Payment extends Eloquent
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payment';

    protected $fillable = ['name'];
}
