<?php
namespace Plugins\Customer\Controllers\Web;

use Illuminate\Http\Request;
use Core\Base\Controllers\Web\BasePublicController;
use Plugins\Customer\Requests\UpdateMyAccountRequest;
use Core\Base\Responses\BaseHttpResponse;
use Illuminate\Support\Facades\Auth;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;
use Plugins\Customer\Services\IOrderService;
use Plugins\Customer\Repositories\Interfaces\OrderRepositories;
use Plugins\Customer\Events\EventConfirmOrder;
use Plugins\Customer\Events\EventSendRefundOrder;

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

	/**
	 * [$orderRepositories description]
	 * @var [type]
	 */
	private $orderRepositories;

	public function __construct(CustomerRepositories $customer, IOrderService $orderService, OrderRepositories $orderRepositories)
	{
		$this->customerRepositories = $customer;
		$this->orderService         = $orderService;
		$this->orderRepositories    = $orderRepositories;
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
		return view('pages.order.myorders', compact('myorders'));
	}

	/**
	 * [detail description]
	 * @param  [type]  $id      [description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function myOrderDetail($id, Request $request)
	{
		$order = $this->orderRepositories->getFirstBy([
			'id' => (int)$id,
			'customer_id' => get_current_customer()->id
		]);

		if(!$order) abort(404, 'not found your order');
		return view('pages.order.detail', compact('order'));
	}

	/**
	 * [resendConfirmation description]
	 * @param  [type]  $id      [description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function resendConfirmation(Request $request)
	{
		$id = $request->id;
		$order = $this->orderRepositories->getFirstBy([
			'id'           => (int)$id,
			'customer_id'  => get_current_customer()->id,
		]);

		if(!$order) return abort(404, 'notfound');
		return event(new EventConfirmOrder($order));
	}

	/**
	 * [resendConfirmation description]
	 * @param  [type]  $id      [description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function sendRefundOrder(Request $request)
	{
		$id = $request->id;
		$order = $this->orderRepositories->getFirstBy([
			'id'           => (int)$id,
			'customer_id'  => get_current_customer()->id,
		]);

		if(!$order) return abort(404, 'notfound');
		return event(new EventSendRefundOrder($order));
	}
}