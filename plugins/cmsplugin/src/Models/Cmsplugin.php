<?php

namespace Plugins\Cmsplugin\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Plugins\Cmsplugin\Models\Cmsplugin
 *
 * @mixin \Eloquent
 */
class Cmsplugin extends Eloquent
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cmsplugin';

    protected $fillable = ['name'];
}
