<?php

namespace Plugins\Customer\Controllers\Admin;

use Illuminate\Http\Request;
use Plugins\Customer\Requests\OrderRequest;
use Plugins\Customer\Repositories\Interfaces\OrderRepositories;
use Plugins\Customer\DataTables\OrderDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;
use Plugins\Customer\Services\IOrderService;
use Core\Base\Responses\BaseHttpResponse;

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
    public function __construct(OrderRepositories $orderRepository)
    {
        $this->orderRepository = $orderRepository;
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
}