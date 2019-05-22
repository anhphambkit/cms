<?php

namespace Plugins\Customer\Requests;

use Core\Master\Requests\CoreRequest;
use Illuminate\Support\Facades\Auth;

class UpdateMyAccountRequest extends CoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author TrinhLe
     */
    public function rules()
    {
    	$customer = Auth::guard('customer')->user();
		$rules = [
			'email'    => "required|max:60|min:6|email|unique:customers,email,{$customer->id}",
			'username' => "required|max:60|min:6|unique:customers,username,{$customer->id}",
			'address'  => 'nullable|array',
		];

		if($this->current_password){
			$ruleExtends = [
				'password'              => 'nullable|max:60|min:6',
				'password_confirmation' => 'nullable|same:password',
			];
		}
		return array_merge($rules, $ruleExtends ?? []);
    }
}
