<?php

namespace Plugins\Product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductKeyword extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_keywords';

    protected $fillable = [
        'name',
        'product_id'
    ];

    /**
     * Get the product that owns the gallery.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}