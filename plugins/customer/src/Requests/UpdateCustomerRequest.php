<?php

namespace Plugins\Customer\Requests;

use Core\Master\Requests\CoreRequest;

class UpdateCustomerRequest extends CoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author TrinhLe
     */
    public function rules()
    {
        $customerId = $this->route()->parameter('id');

        $rules =  [
            'username'          => "required|max:30|min:4|unique:customers,username,{$customerId}",
            'first_name'        => 'required|max:60|min:2',
            'last_name'         => 'required|max:60|min:2',
            'email'             => "required|max:60|min:6|email|unique:customers,email,{$customerId}",
            'dob'               => 'date',
            'address'           => 'max:255',
            'secondary_address' => 'max:255',
            'job_position'      => 'max:255',
            'phone'             => 'max:15',
            'secondary_phone'   => 'max:15',
            'secondary_email'   => 'max:255',
            'gender'            => 'max:255',
            'website'           => 'max:255',
            'skype'             => 'max:255',
            'facebook'          => 'max:255',
            'twitter'           => 'max:255',
            'google_plus'       => 'max:255',
            'youtube'           => 'max:255',
            'github'            => 'max:255',
            'interest'          => 'max:255',
            'about'             => 'max:400',
        ];

        if ($this->input('is_change_password') == 1) {
            $rules['password'] = 'required|min:6|confirmed';
        }

        return $rules;
    }
}
