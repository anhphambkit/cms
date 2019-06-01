<?php
namespace Plugins\Product\Requests;

use Core\Master\Requests\CoreRequest;

class CreditFormRequest extends CoreRequest
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
            'creditcard'                  => 'required|array',
            'creditcard.card_name'        => 'required|min:3|max:100',
            'creditcard.card_number'      => 'required|min:3|max:255',
            'creditcard.card_cvv'         => 'required|min:3|max:255',
            'creditcard.expiration_year'  => 'required|min:3|max:255',
            'creditcard.expiration_month' => 'required',
        ];
    }
}