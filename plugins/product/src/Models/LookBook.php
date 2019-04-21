<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-20
 * Time: 08:25
 */

namespace Plugins\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LookBook extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'look_books';

    protected $fillable = [
        'name',
        'description',
        'short_description',
        'image',
        'permalink',
        'created_by',
        'updated_by',
    ];
}