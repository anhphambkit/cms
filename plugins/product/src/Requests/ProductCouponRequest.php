<?php
namespace Plugins\Product\Requests;

use Core\Master\Requests\CoreRequest;

class ProductCouponRequest extends CoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author TrinhLe
     */
    public function rules()
    {
        return [
            'name'             => 'required',
            'product_category' => 'required_if:is_all_product,0|min:1',
            'coupon_type'      => 'required|in:0,1',
            'coupon_value'     => 'required|min:0',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date',
            'number_coupon'    => 'required|numeric|min:1',
        ];
    }
}