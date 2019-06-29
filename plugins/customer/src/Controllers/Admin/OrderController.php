<?php

namespace Plugins\Customer\Controllers\Admin;

use Illuminate\Http\Request;
use Plugins\Customer\Requests\OrderRequest;
use Plugins\Customer\Repositories\Interfaces\OrderRepositories;
use Plugins\Customer\DataTables\OrderDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;
use Core\Base\Responses\BaseHttpResponse;
use Plugins\Customer\Contracts\OrderReferenceConfig;

class OrderController extends BaseAdminController
{
    /**
     * @var OrderRepositories
     */
    protected $orderRepository;

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
     * Display all order
     * @param OrderDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(OrderDataTable $dataTable)
    {
        page_title()->setTitle(trans('plugins-customer::order.list'));
        return $dataTable->render('plugins-customer::order.index');
    }

    /**
     * Show edit form
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getEdit($id)
    {
        $order = $this->orderRepository->findOrFail($id);
        $listStates = get_states();
        foreach($listStates as $state){
            $states[$state->id] = $state->name;
        }

        $listStatus = get_reference_by_type(OrderReferenceConfig::REFERENCE_ORDER_STATUS);
        foreach($listStatus as $status){
            $orderStatus[$status->id] = $status->display_value;
        }

        page_title()->setTitle(trans('plugins-customer::order.edit') . ' #' . $id);
        return view('plugins-customer::order.edit', compact('order', 'states', 'orderStatus'));
    }

    /**
     * @param $id
     * @param OrderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postEdit($id, OrderRequest $request, BaseHttpResponse $response)
    {
        $order = $this->orderRepository->findOrFail($id);
        
        $order->fill($request->only([
            'address_billing',
            'address_shipping',
            'status'
        ]));

        $this->orderRepository->createOrUpdate($order);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, ORDER_MODULE_SCREEN_NAME, $request, $order);

        return $response
            ->setPreviousUrl(route('admin.order.list'))
            ->setMessage(trans('core-base::notices.update_success_message'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     * @author TrinhLe
     */
    public function getDelete(Request $request, $id)
    {
        try {
            $order = $this->orderRepository->findOrFail($id);
           
            $this->orderRepository->delete($order);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, ORDER_MODULE_SCREEN_NAME, $request, $order);

            return [
                'error' => false,
                'message' => trans('core-base::notices.deleted'),
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => trans('core-base::notices.cannot_delete'),
            ];
        }
    }
}
