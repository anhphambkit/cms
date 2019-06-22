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
use Plugins\Customer\Requests\TrackingNumberRequest;

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
	public function applyTrackingNumber($id, TrackingNumberRequest $request, BaseHttpResponse $response)
	{
		$order = $this->orderRepository->findOrFail((int)$id);
        if($order->tracking_number){
            return $response
                ->setError()
                ->setMessage(trans('Tracking number was added.'));
        }

        $order->fill([
            'tracking_number' => $request->tracking_number
        ]);
        $this->orderRepository->createOrUpdate($order);

        return $response
                ->setMessage(trans('Add tracking number success.'));
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