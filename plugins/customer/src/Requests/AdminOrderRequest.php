<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-07-04
 * Time: 10:05
 */

namespace Plugins\Customer\Requests;

use Core\Master\Requests\CoreRequest;

class AdminOrderRequest extends CoreRequest
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
            'address_shipping'              => 'required|array',
            'address_shipping.last_name'    => 'required|min:3|max:100',
            'address_shipping.email'        => 'required|min:3|max:100',
            'address_shipping.first_name'   => 'required|min:3|max:100',
            'address_shipping.address_1'    => 'required|min:3|max:255',
            'address_shipping.city'         => 'required|min:3|max:255',
            'address_shipping.state'        => 'required',
            'address_shipping.zip'          => 'required|min:3|max:30',
            'address_shipping.phone_number' => 'required|min:3|max:50',
        ];
    }
}
