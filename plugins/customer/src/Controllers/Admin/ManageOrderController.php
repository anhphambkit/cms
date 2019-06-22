<?php

namespace Plugins\Customer\Controllers\Admin;

use Illuminate\Http\Request;
use Plugins\Customer\Requests\OrderRequest;
use Plugins\Customer\Repositories\Interfaces\OrderRepositories;
use Plugins\Customer\DataTables\OrderDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;
use Plugins\Customer\Services\IOrderService;
use Core\Base\Responses\BaseHttpResponse;
use Plugins\Customer\Events\EventConfirmOrder;

class ManageOrderController extends BaseAdminController
{
    /**
     * @var OrderRepositories
     */
    protected $orderRepository;

    /**
     * [$orderService description]
     * @var [type]
     */
    protected $orderService;

    /**
     * OrderController constructor.
     * @param OrderRepositories $orderRepository
     * @author TrinhLe
     */
    public function __construct(OrderRepositories $orderRepository, IOrderService $orderService)
    {
        $this->orderRepository = $orderRepository;
        $this->orderService    = $orderService;
    }

    /**
	 * [applyTrackingNumber description]
	 * @param  [type]           $id       [description]
	 * @param  Request          $request  [description]
	 * @param  BaseHttpResponse $response [description]
	 * @return [type]                     [description]
	 */
	public function applyTrackingNumber($id, Request $request, BaseHttpResponse $response)
	{
		$order = $this->findOrder($id);
		return $response
            ->setPreviousUrl(route('public.customer.my-orders'))
            ->setNextUrl(route('public.customer.my-orders'))
            ->setMessage(trans('Apply tracking number success.'));
	}

    /**
     * [resendConfirmation description]
     * @param  [type]  $id      [description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function resendConfirmation($id, Request $request, BaseHttpResponse $response)
    {
        $order = $this->orderRepository->findOrFail((int)$id);
        event(new EventConfirmOrder($order));
        return $response
                ->setMessage(trans('Send Confirm Order Success.'));
    }
}