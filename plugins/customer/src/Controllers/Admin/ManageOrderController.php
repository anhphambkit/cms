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
use Plugins\Customer\Repositories\Interfaces\ProductsInOrderRepositories;

class ManageOrderController extends BaseAdminController
{
    /**
     * @var OrderRepositories
     */
    protected $orderRepository;

    /**
     * IOrderService
     * @var [type]
     */
    protected $orderService;

    /**
     * ProductsInOrderRepositories
     * @var [type]
     */
    protected $productOrderRepository;

    /**
     * OrderController constructor.
     * @param OrderRepositories $orderRepository
     * @author TrinhLe
     */
    public function __construct(OrderRepositories $orderRepository, IOrderService $orderService, ProductsInOrderRepositories $productOrderRepository)
    {
        $this->orderRepository        = $orderRepository;
        $this->orderService           = $orderService;
        $this->productOrderRepository = $productOrderRepository;
    }

    /**
     * applyTrackingNumber
     * @param type $id 
     * @param TrackingNumberRequest $request 
     * @param BaseHttpResponse $response 
     * @return \Illuminate\Http\JsonResponse
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
     * resendConfirmation
     * @param type $id 
     * @param Request $request 
     * @param BaseHttpResponse $response 
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendConfirmation($id, Request $request, BaseHttpResponse $response)
    {
        $order = $this->orderRepository->findOrFail((int)$id);
        event(new EventConfirmOrder($order));
        return $response
                ->setMessage(trans('Send Confirm Order Success.'));
    }

    /**
     * removeProductOrder
     * @param type $id 
     * @param type $idProductOrder 
     * @param Request $request 
     * @param BaseHttpResponse $response 
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeProductOrder($idProductOrder, Request $request, BaseHttpResponse $response)
    {
        try {
            $productOrder = $this->productOrderRepository->findOrFail((int)$idProductOrder);
            // $this->productOrderRepository->delete($productOrder);

            return $response
                ->setMessage(trans('core-base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage(trans('core-base::notices.cannot_delete'));
        }
       
    }

    /**
     * addProductOrder
     * @param type $id 
     * @param Request $request 
     * @param BaseHttpResponse $response 
     * @return \Illuminate\Http\JsonResponse
     */
    public function addProductOrder($idOrder, Request $request, BaseHttpResponse $response)
    {

    }
}