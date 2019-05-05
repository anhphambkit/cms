<?php
namespace Plugins\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProductCoupon extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_coupons';

    /**
     * Define list columns
     * 
     * @var array
     */
    protected $fillable = [
        'number',
        'start_date',
        'end_date',
        'code',
        'created_by',
        'updated_by',
        'product_category',
        'is_all_product',
        'status'
    ];

    /**
     * Column datetime
     * 
     * @var array
     */
    protected $dates = [
        'start_date',
        'end_date',
    ];

    /**
     * Set value startDate attribute
     * @author TrinhLe
     * @param mixed $value 
     */
    public function setStartDateAttribute($value){
        return $this->attributes['start_date'] = $value ?: Carbon::now();
    }

    /**
     * Set value endDate attribute
     * @author TrinhLe
     * @param mixed $value 
     */
    public function setEndDateAttribute($value){
        return $this->attributes['end_date'] = $value ?: Carbon::now();
    }

    /**
     * Set value isAllProduct attribute
     * @author TrinhLe
     * @param mixed $value 
     */
    public function setIsAllProductAttribute($value){
        return $this->attributes['is_all_product'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}