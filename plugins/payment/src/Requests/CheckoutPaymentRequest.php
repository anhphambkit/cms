<?php

namespace Plugins\Payment\Requests;

use Core\Master\Requests\CoreRequest;

class CheckoutPaymentRequest extends CoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author TrinhLe
     */
    public function rules()
    {
        return [];
    }
}
