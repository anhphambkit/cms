<?php
namespace Plugins\Product\Requests;

use Core\Master\Requests\CoreRequest;

class CheckoutFormRequest extends CoreRequest
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

            'address_billing'              => 'required|array',
            'address_billing.first_name'   => 'required|min:3|max:100',
            'address_billing.last_name'    => 'required|min:3|max:100',
            'address_billing.address_1'    => 'required|min:3|max:255',
            'address_billing.city'         => 'required|min:3|max:255',
            'address_billing.state'        => 'required',
            'address_billing.zip'          => 'required|min:3|max:30',
            'address_billing.phone_number' => 'required|min:3|max:50',
        ];
    }
}