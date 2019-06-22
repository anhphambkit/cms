<?php

namespace Plugins\Customer\Requests;

use Core\Master\Requests\CoreRequest;

class TrackingNumberRequest extends CoreRequest
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
            'tracking_number' => 'required|string|max:120|min:5',
        ];
    }
}
