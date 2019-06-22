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
use Plugins\Customer\Events\EventSendRefundOrder;
use Plugins\Customer\Events\EventSendOrderProduct;

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
		$order = $this->orderService->findOrderCustomer(['id' => (int)$id]);
		return view('pages.order.detail', compact('order'));
	}

	/**
	 * [returnProductOrder description]
	 * @param  [type]           $idOrder   [description]
	 * @param  [type]           $idProduct [description]
	 * @param  Request          $request   [description]
	 * @param  BaseHttpResponse $response  [description]
	 * @return [type]                      [description]
	 */
	public function returnProductOrder($idOrder, $idProduct, Request $request, BaseHttpResponse $response)
	{
		$order = $this->orderService->findOrderCustomer(['id' => (int)$idOrder]);
		event(new EventSendOrderProduct($order, EMAIL_RETURN_PRODUCT_ORDER));
		return $response
                ->setMessage(trans('Send Refund Order Success.'));
	}

	/**
	 * [replaceProductOrder description]
	 * @param  [type]           $idOrder   [description]
	 * @param  [type]           $idProduct [description]
	 * @param  Request          $request   [description]
	 * @param  BaseHttpResponse $response  [description]
	 * @return [type]                      [description]
	 */
	public function replaceProductOrder($idOrder, $idProduct, Request $request, BaseHttpResponse $response)
	{
		$order = $this->orderService->findOrderCustomer(['id' => (int)$idOrder]);
		event(new EventSendOrderProduct($order, EMAIL_REPLACE_PRODUCT_ORDER));
		return $response
                ->setMessage(trans('Send Replace Order Success.'));
	}

	/**
	 * [cancelProductOrder description]
	 * @param  [type]           $idOrder   [description]
	 * @param  [type]           $idProduct [description]
	 * @param  Request          $request   [description]
	 * @param  BaseHttpResponse $response  [description]
	 * @return [type]                      [description]
	 */
	public function cancelProductOrder($idOrder, $idProduct, Request $request, BaseHttpResponse $response)
	{
		$order = $this->orderService->findOrderCustomer(['id' => (int)$idOrder]);
		event(new EventSendOrderProduct($order, EMAIL_CANCEL_PRODUCT_ORDER));
		return $response
                ->setMessage(trans('Send Cancel Order Success.'));
	}
}