<?php

namespace Plugins\Customer\Requests;

use Core\Master\Requests\CoreRequest;

class CustomerRequest extends CoreRequest
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
            'first_name' => 'required|max:120|min:2',
            'last_name'  => 'required|max:120|min:2',
            'email'      => 'required|max:60|min:6|email|unique:customers',
            'username'   => 'required|max:60|min:6|unique:customers',
            'password'   => 'required|min:6|confirmed',
        ];
    }
}
