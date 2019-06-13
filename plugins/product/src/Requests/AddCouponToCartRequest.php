<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-13
 * Time: 06:33
 */
namespace Plugins\Product\Requests;

use Core\Master\Requests\CoreRequest;

class AddCouponToCartRequest extends CoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author AnhPham
     */
    public function rules()
    {
        return [
            'coupon_code' => 'required',
        ];
    }
}