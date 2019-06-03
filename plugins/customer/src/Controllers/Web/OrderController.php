<?php
namespace Plugins\Customer\Controllers\Web;

use Illuminate\Http\Request;
use Core\Base\Controllers\Web\BasePublicController;
use Plugins\Customer\Requests\UpdateMyAccountRequest;
use Core\Base\Responses\BaseHttpResponse;
use Illuminate\Support\Facades\Auth;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;
use Hash;
use Plugins\Customer\Services\IOrderService;

class OrderController extends BasePublicController
{
	/**
	 * @var CustomerRepositories
	 */
	private $customerRepositories;

	/**
	 * [$orderService description]
	 * @var IOrderService
	 */
	private $orderService;

	public function __construct(CustomerRepositories $customer, IOrderService $orderService)
	{
		$this->customerRepositories = $customer;
		$this->orderService         = $orderService;
	}

	/**
	 * Show my orders customer
	 * @param Request $request 
	 * @author  TrinhLe 
	 * @return Illuminate\View\View
	 */
	public function getMyOrders(Request $request)
	{
		$myorders = $this->orderService->getMyOrders(get_current_customer()->id);
		return view("plugins-customer::account.myorders", compact('myorders'));
	}
}