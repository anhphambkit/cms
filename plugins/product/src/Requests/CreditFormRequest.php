<?php
namespace Plugins\Product\Requests;

use Core\Master\Requests\CoreRequest;
use Plugins\Payment\Contracts\PaymentReferenceConfig;


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
        $cardType = implode(',', [
            PaymentReferenceConfig::REFERENCE_PAYMENT_PAYPAL_CARD_NAME_VISA,
            PaymentReferenceConfig::REFERENCE_PAYMENT_PAYPAL_CARD_NAME_MASTER,
            PaymentReferenceConfig::REFERENCE_PAYMENT_PAYPAL_CARD_NAME_DISCOVER,
            PaymentReferenceConfig::REFERENCE_PAYMENT_PAYPAL_CARD_NAME_AMEX,
        ]);

        return [
            'creditcard'                  => 'required|array',
            'creditcard.card_name'        => "required|min:3|max:100|in:{$cardType}",
            'creditcard.card_number'      => 'required|min:3|max:255',
            'creditcard.last_name'        => 'required|min:3|max:255',
            'creditcard.first_name'       => 'required|min:3|max:255',
            'creditcard.card_cvv'         => 'required|min:3|max:255',
            'creditcard.expiration_year'  => 'required|min:3|max:255',
            'creditcard.expiration_month' => 'required',
        ];
    }
}