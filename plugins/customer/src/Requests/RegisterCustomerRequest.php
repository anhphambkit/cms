<?php

namespace Plugins\Customer\Requests;

use Core\Master\Requests\CoreRequest;

class RegisterCustomerRequest extends CoreRequest
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
            'email'      => 'required|max:60|min:6|email|unique:customers',
            'username'   => 'required|max:60|min:6|unique:customers',
            'password'   => 'required|min:6|confirmed',
        ];
    }
}
