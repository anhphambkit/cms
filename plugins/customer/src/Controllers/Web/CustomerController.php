<?php

namespace Plugins\Customer\Controllers\Web;
use Illuminate\Http\Request;
use Core\Base\Controllers\Web\BasePublicController;
use Plugins\Customer\Requests\UpdateMyAccountRequest;
use Core\Base\Responses\BaseHttpResponse;
use Illuminate\Support\Facades\Auth;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;
use Hash;

class CustomerController extends BasePublicController
{
	/**
	 * @var CustomerRepositories
	 */
	private $customerRepositories;

	public function __construct(CustomerRepositories $customer)
	{
        parent::__construct();
		$this->customerRepositories = $customer;
	}

	/**
	 * Show my account customer
	 * @param Request $request 
	 * @author  TrinhLe 
	 * @return Illuminate\View\View
	 */
	public function getMyAccount(Request $request)
	{
		return view("plugins-customer::account.myaccount");
	}

	/**
	 * Update myaccount information
	 * @param  UpdateMyAccountRequest $request  [description]
	 * @param  BaseHttpResponse       $response [description]
	 * @return Illuminate\View\View
	 */
	public function postMyAccount(UpdateMyAccountRequest $request, BaseHttpResponse $response)
	{
		$customer = Auth::guard('customer')->user();
		$formated = array_merge($request->only([
			'email',
			'username'
		]),[
			'address' => json_encode($request->input('address', []))
		]);

		if($request->current_password){
			if (!Hash::check($request->input('current_password'), $customer->getAuthPassword())) {
	            return redirect()->back()->with('error_msg', trans('core-user::users.current_password_not_valid'));
	        }

	        $formated = array_merge($formated, [
	        	'password' => Hash::make($request->input('password'))
	        ]);
		}
		$customer->fill($formated);
		$this->customerRepositories->createOrUpdate($customer);

		return $response
            ->setPreviousUrl(route('public.customer.dashboard'))
            ->setMessage(trans('core-base::notices.update_success_message'));
	}
}