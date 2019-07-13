<?php

namespace Plugins\Review\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plugins\Customer\Models\Customer;

/**
 * Plugins\Review\Models\Review
 *
 * @mixin \Eloquent
 */
class Review extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_reviews';

    protected $fillable = [
		'content',
		'rating',
		'status',
        'product_id',
    ];

    /**
     * @return relationship
     */
    public function comments(){
    	return $this->hasMany(ReviewComment::class, 'review_id');
    }

    /**
     * @return relationship
     */
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id')->withDefault();
    }
}
