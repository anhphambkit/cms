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
use Plugins\Customer\Repositories\Interfaces\ProductsInOrderRepositories;
use URL;

class OrderController extends BasePublicController
{
	/**
	 * @var CustomerRepositories
	 */
	private $customerRepositories;

	/**
	 * @var IOrderService
	 */
	private $orderService;

	/**
	 * @var OrderRepositories
	 */
	private $orderRepositories;

	/**	
	 * @var ProductsInOrderRepositories
	 */
	private $productOrder;

	public function __construct(CustomerRepositories $customer, IOrderService $orderService, OrderRepositories $orderRepositories, ProductsInOrderRepositories $productOrder)
	{
		$this->customerRepositories = $customer;
		$this->orderService         = $orderService;
		$this->orderRepositories    = $orderRepositories;
		$this->productOrder         = $productOrder;
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
	 * @param  [type]  $id     
	 * @param  Request $request
	 * @return [type]          
	 */
	public function myOrderDetail($id, Request $request)
	{
		$order = $this->orderService->findOrderCustomer(['id' => (int)$id]);
		return view('pages.order.detail', compact('order'));
	}

	/**
	 * [returnProductOrder description]
	 * @param  [type]           $idOrder  
	 * @param  [type]           $idProduct
	 * @param  Request          $request  
	 * @param  BaseHttpResponse $response 
	 * @return [type]                     
	 */
	public function returnProductOrder($idOrder, $idProduct, Request $request, BaseHttpResponse $response)
	{
		$order = $this->orderService->findOrderCustomer(['id' => (int)$idOrder]);

		$this->productOrder->update([
			'order_id' => (int)$idOrder,
			'product_id' => (int)$idProduct
		],['is_return' => true]);

		event(new EventSendOrderProduct($order, EMAIL_RETURN_PRODUCT_ORDER));
		return $response
                ->setMessage(trans('Send Refund Order Success.'));
	}

	/**
	 * [replaceProductOrder description]
	 * @param  [type]           $idOrder  
	 * @param  [type]           $idProduct
	 * @param  Request          $request  
	 * @param  BaseHttpResponse $response 
	 * @return [type]                     
	 */
	public function replaceProductOrder($idOrder, $idProduct, Request $request, BaseHttpResponse $response)
	{
		$order = $this->orderService->findOrderCustomer(['id' => (int)$idOrder]);

		$this->productOrder->update([
			'order_id' => (int)$idOrder,
			'product_id' => (int)$idProduct
		],['is_replace' => true]);

		event(new EventSendOrderProduct($order, EMAIL_REPLACE_PRODUCT_ORDER));
		return $response
                ->setMessage(trans('Send Replace Order Success.'));
	}

	/**
	 * [cancelProductOrder description]
	 * @param  [type]           $idOrder  
	 * @param  [type]           $idProduct
	 * @param  Request          $request  
	 * @param  BaseHttpResponse $response 
	 * @return [type]                     
	 */
	public function cancelProductOrder($idOrder, $idProduct, Request $request, BaseHttpResponse $response)
	{
		$order = $this->orderService->findOrderCustomer(['id' => (int)$idOrder]);

		$this->productOrder->update([
			'order_id' => (int)$idOrder,
			'product_id' => (int)$idProduct
		],['is_cancel' => true]);
		
		event(new EventSendOrderProduct($order, EMAIL_CANCEL_PRODUCT_ORDER));
		return $response
                ->setMessage(trans('Send Cancel Order Success.'));
	}

	/**
	 * [getConfirmation description]
	 * @param  [type]           $idOrder 
	 * @param  Request          $request 
	 * @return Illuminate\View\View
	 */				
	public function getConfirmation($idOrder, Request $request)
	{
		if (!URL::hasValidSignature($request)) {
            abort(404);
        }

		$order = $this->orderService->findOrderCustomer(['id' => (int)$idOrder]);
		return view('pages.order.order-confirmation', compact('order'));
	}
}