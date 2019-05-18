<?php

namespace Plugins\Customer\Controllers\Web;
use Core\Base\Controllers\Web\BasePublicController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Plugins\Customer\Requests\RegisterCustomerRequest;
use URL;

class RegisterController extends BasePublicController
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * [showRegisterForm description]
	 * @param  Request $request [description]
	 * @return Illuminate\View\View
	 */
	public function showRegisterForm(Request $request)
	{
		page_title()->setTitle('Register');
		return view('plugins-customer::auth.register');
	}

	/**
	 * [register description]
	 * @param  RegisterCustomerRequest $request [description]
	 * @return [type]                           [description]
	 */
	public function register(RegisterCustomerRequest $request)
	{

	}
}