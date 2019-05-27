<?php
namespace Plugins\Customer\Controllers\Web;

use Illuminate\Http\Request;
use Core\Base\Controllers\Web\BasePublicController;
use Plugins\Customer\Requests\UpdateMyAccountRequest;
use Core\Base\Responses\BaseHttpResponse;
use Illuminate\Support\Facades\Auth;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;
use Hash;

class OrderController extends BasePublicController
{
	/**
	 * @var CustomerRepositories
	 */
	private $customerRepositories;

	public function __construct(CustomerRepositories $customer)
	{
		$this->customerRepositories = $customer;
	}

	/**
	 * Show my orders customer
	 * @param Request $request 
	 * @author  TrinhLe 
	 * @return Illuminate\View\View
	 */
	public function getMyOrders(Request $request)
	{
		return view("plugins-customer::account.myorders");
	}
}