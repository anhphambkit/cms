<?php

namespace Plugins\Review\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Plugins\Review\Models\Review
 *
 * @mixin \Eloquent
 */
class ReviewComment extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_review_comments';

    protected $fillable = [
    	'content',
        'review_id'
    ];

    /**
     * @return relationship
     */
    public function review(){
        return $this->belongsTo(Review::class, 'review_id');
    }

    /**
     * @return relationship
     */
    public function author(){
        return $this->morphTo();
    }
}
